<?php
    include './dbconfig.php';
?>
<div class="row" style="margin-bottom: -10px;">
    <!-- +/- PEZZI TRATTATI -->
    <div class="box-sales">
        <span class="title">Articoli</span>
        <div class="content">
            <span class="value">145 pz</span>
        </div>
    </div>
    <!-- VENDITE DAILY -->
    <div class="box-sales">
        <span class="title">Vendite daily</span>
        <div class="content">
            <span class="value">€ 90,00</span>
        </div>
        <canvas id="dailySalesChart" height="100"></canvas>
        <script>
        fetch('./sezioni/analytics/vendite_daily.php')
        .then(res => res.json())
        .then(json => {
            const canvas = document.getElementById('dailySalesChart');
            const ctx = canvas.getContext('2d');

            const gradient = ctx.createLinearGradient(0, 0, 0, canvas.height);
            gradient.addColorStop(0, 'rgba(43,43,43,0.2)');
            gradient.addColorStop(1, 'rgba(43,43,43,0)');

            const labels = json.map(e => e.ora); // "09:00", "10:00" ...
            const values = json.map(e => e.totale);

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Vendite orarie',
                        data: values,
                        fill: true,
                        backgroundColor: gradient,
                        tension: 0.9,
                        cubicInterpolationMode: 'monotone',
                        borderColor: 'var(--black)',
                        borderWidth: 2,
                        clip: false,
                        pointBackgroundColor: (ctx) => ctx.dataIndex === values.length - 1 ? 'var(--black)' : 'transparent',
                        pointRadius: (ctx) => ctx.dataIndex === values.length - 1 ? 6 : 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    layout: { padding: { right: 10 } },
                    plugins: {
                        legend: { display: false },
                        tooltip: { enabled: false }
                    },
                    scales: {
                        x: { display: false },
                        y: { display: false }
                    }
                }
            });
        });
        </script>
    </div>
    <!-- VENDITE MESE -->
    <div class="box-sales">
        <span class="title">Vendite mese</span>
        <div class="content">
            <span class="value">€ 615,00</span>
            <canvas id="monthlySalesChart" height="100"></canvas>
            <script>
            fetch('./sezioni/analytics/vendite_mese.php')
            .then(res => res.json())
            .then(json => {
                const canvas = document.getElementById('monthlySalesChart');
                const ctx = canvas.getContext('2d');

                const gradient = ctx.createLinearGradient(0, 0, 0, canvas.height);
                gradient.addColorStop(0, 'rgba(43,43,43,0.2)');
                gradient.addColorStop(1, 'rgba(43,43,43,0)');

                const labels = json.map(e => e.giorno.slice(5)); // "05-01" → "05-01"
                const values = json.map(e => e.totale);

                new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                    label: 'Vendite',
                    data: values,
                    fill: true,
                    backgroundColor: gradient,
                    tension: 0.9,
                    cubicInterpolationMode: 'monotone',
                    borderColor: 'var(--black)',
                    borderWidth: 2,
                    clip: false,
                    pointBackgroundColor: (ctx) => ctx.dataIndex === values.length - 1 ? 'var(--black)' : 'transparent',
                    pointRadius: (ctx) => ctx.dataIndex === values.length - 1 ? 6 : 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    layout: { padding: { right: 10 } },
                    plugins: {
                    legend: { display: false },
                    tooltip: { enabled: false }
                    },
                    scales: {
                    x: { display: false },
                    y: { display: false }
                    }
                }
                });
            });
            </script>
        </div>
    </div>
</div>

<div class="row">
    <!-- TOP 10 ARTICOLI -->
    <?php
        // query
        $query = "
            SELECT p.nome, p.prezzo, p.seriale
            FROM prodotti p
            JOIN (
                SELECT seriale, SUM(quantita) as totale_vendite
                FROM vendite
                GROUP BY seriale
            ) v ON p.seriale = v.seriale
            ORDER BY v.totale_vendite DESC
            LIMIT 5
        ";
        $result = $conn->query($query);

        // top 5
        if ($result->num_rows > 0) {
            echo '<div class="box-sales">';
                echo '<span class="title" style="margin-bottom: 15px;">Top Articoli</span>';
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="content-article">';
                        $imagePath = './img/' . htmlspecialchars($row['seriale']) . '.png';
                        if (file_exists($imagePath)) {
                            echo '<div class="img-box">';
                            echo '<img src="' . $imagePath . '" alt="box">';
                        } else {
                            $randomPlaceholder = 'placeholder' . rand(1, 4) . '.png';
                            echo '<div class="img-box">';
                            echo '<img src="./img/' . $randomPlaceholder . '" alt="box">';
                        }
                        echo '</div>';
                        echo '<div class="title-box title-box-top-sales">';
                            echo '<span class="title-article">' . htmlspecialchars($row['nome']) . '</span>';
                            echo '<span class="article-price">€ ' . number_format($row['prezzo'], 2, ',', '.') . '</span>';
                        echo '</div>';
                    echo '</div>';
                }
                echo '</div>';
            } else {
                echo '<div class="box-sales">';
                echo '<span class="title">Top Articoli</span>';
                echo '<div class="content-article">Nessun articolo trovato</div>';
            echo '</div>';
        }

        // query
        $query = "
            SELECT v.data, p.nome, v.quantita, p.prezzo, p.seriale
            FROM vendite v
            JOIN prodotti p ON v.seriale = p.seriale
            ORDER BY v.data DESC
            LIMIT 5
        ";
        $result = $conn->query($query);

        // ultime 5 vendite
        if ($result->num_rows > 0) {
            echo '<div class="box-sales">';
                echo '<span class="title" style="margin-bottom: 15px;">Ultime Vendite</span>';
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="content-article">';
                        $imagePath = './img/' . htmlspecialchars($row['seriale']) . '.png';
                        if (file_exists($imagePath)) {
                            echo '<div class="img-box">';
                            echo '<img src="' . $imagePath . '" alt="box">';
                        } else {
                            $randomPlaceholder = 'placeholder' . rand(1, 4) . '.png';
                            echo '<div class="img-box">';
                            echo '<img src="./img/' . $randomPlaceholder . '" alt="box">';
                        }
                        echo '</div>';
                        echo '<div class="title-box title-box-top-sales">';
                            echo '<span class="title-article">' . htmlspecialchars($row['nome']) . '</span>';
                            echo '<span class="article-price">€ ' . number_format($row['prezzo'], 2, ',', '.') . ' x' . $row['quantita'] . '</span>';
                        echo '</div>';
                    echo '</div>';
                }
                echo '</div>';
            } else {
                echo '<div class="box-sales">';
                echo '<span class="title">Top Articoli</span>';
                echo '<div class="content-article">Nessun articolo trovato</div>';
            echo '</div>';
        }

        $conn->close();
    ?>
    <!-- VENDITE MESE -->
    <div class="box-sales">
        <span class="title">Vendite mese</span>
        <div class="content">
            <span class="value">€ 615,00</span>
        </div>
    </div>
</div>