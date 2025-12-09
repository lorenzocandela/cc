<!DOCTYPE html>
<html lang="it">
    <head>
        <meta name="theme-color" content="#202020">
        <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <title>C&C</title>
        <!-- STYLE -->
        <link rel="stylesheet" href="style.css?v=0.1">
        <!-- FONT -->
        <link rel="stylesheet" href="dmfont.css">
        <!-- FONT AWESOME -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
        <!-- JQUERY -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <!-- MANIFEST -->
        <link rel="manifest" href="manifest.json">
        <!-- FAVICON -->
        <link rel="icon" type="image/png" href="favicon.ico">

        <style>
            /* * */
        </style>
    </head>
    <body>
        
        <div id="BACINELLA-NAV">
            <div id="nav-section"> <!-- navbar da mod forse -->
                <?php include './sezioni/navbar.php'?>
            </div>
        </div>


        <div id="tab-dashboard" class="tab-section active-tab">
            <?php include("./tab/dashboard.php"); ?>
        </div>

        <div id="tab-prodotti" class="tab-section">
            <?php include("./tab/prodotti.php"); ?>
        </div>

        <div id="tab-analytics" class="tab-section">
            <?php include("./tab/analytics.php"); ?>
        </div>
        
        <div id="tab-ordini" class="tab-section">
            <?php include("./tab/ordini.php"); ?>
        </div>


        <script src="./js/call_insert_reg.js"></script>

        <script>
            // SERVICE WORKER CHIAMATA
            if ('serviceWorker' in navigator) {
                navigator.serviceWorker.register('service-worker.js')
                .then(function(registration) {
                    console.log('Service Worker registered with scope:', registration.scope);
                }).catch(function(error) {
                    console.log('Service Worker registration failed:', error);
                });
            }
            // MAIN FUNZ REGISTRA VENDITE/INSERISCI PRODOTTO NUOVO
            document.getElementById("form-inserimento").addEventListener("submit", function(e) {
                e.preventDefault();

                const form = e.target;
                const formData = new FormData(form);

                fetch("actions/insert_prodotto.php", {
                    method: "POST",
                    body: formData
                })
                .then(res => res.text())
                .then(text => {
                    const [status, message] = text.split("|");
                    if (status === "OK") {
                        if (confirm(message || "INSERITO ✅! Vuoi inserirne un altro?")) {
                            form.reset();
                        } else {
                            document.getElementById("INSERIMENTO").classList.remove("show");
                            document.getElementById("BACINELLA").classList.remove("blurred");
                            document.getElementById("BACINELLA-NAV").classList.remove("blurred");
                            setTimeout(() => {
                                document.getElementById("INSERIMENTO").style.display = 'none';
                            }, 400);
                        }
                    } else {
                        alert("Errore durante l'inserimento: " + text);
                    }
                })
                .catch(err => {
                    alert("Errore di rete: " + err);
                });
            });

            document.getElementById("form-registro").addEventListener("submit", function(e) {
                e.preventDefault();

                const form = e.target;
                const formData = new FormData(form);

                fetch("actions/registra_vendita.php", {
                    method: "POST",
                    body: formData
                })
                .then(res => res.text())
                .then(text => {
                    const [status, message] = text.split("|");
                    if (status === "OK") {
                        if (confirm(message || "VENDITA REGISTRATA ✅! Vuoi registrare un'altra?")) {
                            form.reset();
                        } else {
                            document.getElementById("REGISTRO").classList.remove("show");
                            document.getElementById("BACINELLA").classList.remove("blurred");
                            document.getElementById("BACINELLA-NAV").classList.remove("blurred");
                            setTimeout(() => {
                                document.getElementById("REGISTRO").style.display = 'none';
                            }, 400);
                        }
                    } else {
                        alert("Errore durante l'inserimento: " + text);
                    }
                })
                .catch(err => {
                    alert("Errore di rete: " + err);
                });
            });
        </script>

    </body>
</html>