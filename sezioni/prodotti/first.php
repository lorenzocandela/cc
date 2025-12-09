<div class="sales">
    <div onclick="resetSort()" class="sales-title">
        <span class="title-div-sez"><img src="./img/ico/reset.svg">Reset <b>ordinamento</b></span>
    </div>
</div>

<div class="sales" style="width: inherit;">
    <input type="text" id="searchInput" placeholder="Cerca per nome, tipo, modello, etc..." class="product-search">
</div>

<script>
// input per ricerca in tabela
document.getElementById('searchInput').addEventListener('keyup', function () {
    const filter = this.value.toLowerCase();
    const rows = document.querySelectorAll('#PRODOTTI tbody tr');

    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(filter) ? '' : 'none';
    });
});
</script>

