<div id="PRODOTTI">
    <?php
    ini_alter('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    include 'dbconfig.php';

    $sql = "SELECT id, nome, modello, tipo, taglia, colore, marca, quantita, seriale, limite, prezzo FROM prodotti ORDER BY id DESC";
    $result = $conn->query($sql);

    echo '<table border="1" cellspacing="0" cellpadding="10">';
    echo '<thead>
        <tr>
            <th data-index="0" onclick="toggleSort(this)"><div class="th-head">Nome <span class="sort-icon"></span></div></th>
            <th data-index="1" onclick="toggleSort(this)"><div class="th-head">Modello <span class="sort-icon"></span></div></th>
            <th data-index="2" onclick="toggleSort(this)"><div class="th-head">Tipo <span class="sort-icon"></span></div></th>
            <th data-index="3" onclick="toggleSort(this)"><div class="th-head">Taglia <span class="sort-icon"></span></div></th>
            <th data-index="4" onclick="toggleSort(this)"><div class="th-head">Colore <span class="sort-icon"></span></div></th>
            <th data-index="5" onclick="toggleSort(this)"><div class="th-head">Marca <span class="sort-icon"></span></div></th>
            <th data-index="6" onclick="toggleSort(this)"><div class="th-head">Quantità <span class="sort-icon"></span></div></th>
            <th data-index="7" onclick="toggleSort(this)"><div class="th-head">Prezzo <span class="sort-icon"></span></div></th>
            <th>Azioni</th>
        </tr>
    </thead>';

    echo '<tbody>';

    while ($row = $result->fetch_assoc()) {
        $quantita = (int)$row['quantita'];
        $status = '';

        if ($quantita > 10) {
            $status = 'troppi';
        } elseif ($quantita <= 4) {
            $status = 'limite';
        } else {
            $status = 'ok';
        }
        echo '<tr>
                <td>' . htmlspecialchars($row['nome']) . '</td>
                <td>' . htmlspecialchars($row['modello']) . '</td>
                <td>' . htmlspecialchars($row['tipo']) . '</td>
                <td>' . htmlspecialchars($row['taglia']) . '</td>
                <td>' . htmlspecialchars($row['colore']) . '</td>
                <td>' . htmlspecialchars($row['marca']) . '</td>
                <td><span class="'. $status . '" style="padding: 3px 20px; border-radius: 7px;">' . htmlspecialchars($row['quantita']) . '</span></td>
                <td>€ ' . number_format($row['prezzo'], 2, ',', '') . '</td>
                <td>
                    <div class="action-dropdown">
                        <button class="action-btn"><img id="menudrop" src="./img/ico/dropdown.svg"></button>
                        <div class="dropdown-menu">
                            <a href="modifica_prodotto.php?id=' . $row['id'] . '">Modifica</a>
                            <a href="sezioni/prodotti/cancella.php?id=' . $row['id'] . '" onclick="return confirm(\'Sei sicuro di voler cancellare questo prodotto?\')">Cancella</a>
                        </div>
                    </div>
                </td>
        </tr>';
    }
    echo '</tbody>';
    echo '</table>';

    $conn->close();
    ?>
    <div id="load-more-btn">
        <button id="loadmore" class="btn"><img id="carica" src="./img/ico/load.svg"> Carica</button>
    </div>
</div>

<script>
// drop down menu edit e canc
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.action-btn').forEach(function (btn) {
        btn.addEventListener('click', function (e) {
            e.stopPropagation();
            document.querySelectorAll('.action-dropdown').forEach(function (d) {
                d.classList.remove('active');
            });
            this.closest('.action-dropdown').classList.toggle('active');
        });
    });

    document.addEventListener('click', function () {
        document.querySelectorAll('.action-dropdown').forEach(function (d) {
            d.classList.remove('active');
        });
    });
});
</script>

<script>
// tabella ordinamento per col
let sortStack = [];

function toggleSort(th) {
    const colIndex = parseInt(th.getAttribute('data-index'));
    const iconSpan = th.querySelector('.sort-icon');
    const existing = sortStack.find(s => s.col === colIndex);

    if (existing) {
        existing.order = existing.order === 'asc' ? 'desc' : 'asc';
    } else {
        sortStack.push({ col: colIndex, order: 'asc' });
    }

    sortTableMultiple();
    updateIcons();
}

function resetSort() {
    sortStack = [];
    document.querySelectorAll('.sort-icon').forEach(icon => icon.innerHTML = '');
    sortTableMultiple();
}

function sortTableMultiple() {
    const table = document.querySelector('#PRODOTTI table');
    const tbody = table.tBodies[0];
    const rows = Array.from(tbody.rows);

    rows.sort((a, b) => {
        for (let { col, order } of sortStack) {
            let aVal = a.cells[col].textContent.trim();
            let bVal = b.cells[col].textContent.trim();

            const isPrice = col === 7;
            const isNumeric = col === 6 || col === 7;

            if (isPrice) {
                aVal = parseFloat(aVal.replace(/[^\d,]/g, '').replace(',', '.'));
                bVal = parseFloat(bVal.replace(/[^\d,]/g, '').replace(',', '.'));
            } else if (isNumeric) {
                aVal = parseFloat(aVal);
                bVal = parseFloat(bVal);
            } else {
                aVal = aVal.toLowerCase();
                bVal = bVal.toLowerCase();
            }

            if (aVal < bVal) return order === 'asc' ? -1 : 1;
            if (aVal > bVal) return order === 'asc' ? 1 : -1;
        }
        return 0;
    });

    rows.forEach(row => tbody.appendChild(row));
}

function updateIcons() {
    document.querySelectorAll('#PRODOTTI th .sort-icon').forEach(icon => icon.innerHTML = '');
    sortStack.forEach(({ col, order }) => {
        const th = document.querySelector(`#PRODOTTI th[data-index="${col}"] .sort-icon`);
        th.innerHTML = order === 'asc' ? '<img id="menudrop" src="./img/ico/arrowup.svg">' : '<img id="menudrop" src="./img/ico/arrowdown.svg">';
    });
}
</script>
