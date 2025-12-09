<nav>
    <ul>
        <li><a class="active" href="#">Dashboard</a></li>
        <li><a href="#">Prodotti</a></li>
        <li><a href="#">Analytics</a></li>
        <li><a href="#">Ordini</a></li>
        <li class="settings-box"><img id="settings" src="./img/ico/settings.svg"></li> <!-- onclick funzione per call -->
    </ul>
</nav>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const links = document.querySelectorAll('nav ul li a');
        const tabMap = {
            'Dashboard': 'tab-dashboard',
            'Prodotti': 'tab-prodotti',
            'Analytics': 'tab-analytics',
            'Ordini': 'tab-ordini'
        };

        links.forEach(link => {
            link.addEventListener('click', function (event) {
                event.preventDefault();

                // link
                links.forEach(l => l.classList.remove('active'));
                this.classList.add('active');

                // tab
                const text = this.textContent.trim();
                const targetId = tabMap[text];
                const tabs = document.querySelectorAll('.tab-section');

                tabs.forEach(tab => tab.classList.remove('active-tab'));
                if (targetId) {
                    document.getElementById(targetId).classList.add('active-tab');
                }
            });
        });
    });
</script>
