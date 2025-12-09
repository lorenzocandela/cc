<?php
ini_alter('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'dbconfig.php';

$sql = "SELECT nome, modello, tipo, taglia, colore, marca, quantita, seriale, limite, prezzo FROM prodotti ORDER BY id DESC";
$result = $conn->query($sql);

$counter = 0;
echo '<div class="row">';
while ($row = $result->fetch_assoc()) {
    // se esiste l'immagine del prodotto, la carico altrimenti placeholder casuale da 1 a 4 dei def
    $imgSrc = "./img/" . $row['seriale'] . ".png";
    if (!file_exists($imgSrc)) {
        $imgIndex = rand(1, 4);
        $imgSrc = "./img/placeholder" . $imgIndex . ".png";
    }

    // stato limite TODO: Da definire con mamma le qty per i vari stati
    $dispoClass = "ok";
    $dispoText = "OK";
    if ($row['quantita'] <= 2) {
        $dispoClass = "limite";
        $dispoText = "LIMITE";
    } elseif ($row['quantita'] >= 15) {
        $dispoClass = "troppi";
        $dispoText = "TROPPI";
    }

    // color in classe CSS
    $colorClass = strtolower($row['colore']);

    echo '<div class="box-article">
            <div class="img-box">
                <img src="' . $imgSrc . '" alt="box">
            </div>
            <div class="title-box">
                <span class="title-article">' . htmlspecialchars($row['nome']) . '</span>
                <span class="article-price">€ ' . number_format($row['prezzo'], 2, ',', '') . '</span>
            </div>
            <div class="tag-dispo">
                <span class="tag-div-sez ' . $dispoClass . '">' . $dispoText . '</span>
            </div>
            <div class="tag-colore">
                <span class="tag-color-div-sez ' . $colorClass . '" alt="' . ucfirst($row['colore']) . '"></span>
            </div>
            <div class="info-box">';
                
    // modello modello solo se diverso da "classico" o " " 
    if (!in_array(strtolower($row['modello']), ['classico', ''])) {
        echo '<span class="type-article">' . htmlspecialchars($row['modello']) . ', </span>';
    }
    echo       '<span class="material-article">' . htmlspecialchars($row['tipo']) . ', </span>
                <span class="brand-article">' . htmlspecialchars($row['marca']) . ', </span>
                <span class="size-article">' . htmlspecialchars($row['taglia']) . ', </span>
            </div>
        </div>';

    $counter++;
    if ($counter % 4 === 0) {
        echo '</div><div class="row">';
    }
}
echo '</div>';

$conn->close();
?>
