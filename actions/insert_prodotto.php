<?php
include '../dbconfig.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // form
    $nome = $_POST['product-name'];
    $codice = $_POST['product-code'];
    $modello = $_POST['product-model'];
    $tipo = $_POST['product-type'];
    $taglia = $_POST['product-size'];
    $colore = $_POST['product-color'];
    $marca = $_POST['product-brand'];
    $categoria = $_POST['product-category'];
    $quantita = intval($_POST['product-quantity']);
    $seriale = $_POST['product-serial'];
    $prezzo = floatval($_POST['product-price']);

    // def
    $stato = 'Disponibile';
    $data_inserimento = date('Y-m-d H:i:s');
    $data_modifica = $data_inserimento;
    $limite = 'NO';

    // query
    $stmt = $conn->prepare("INSERT INTO prodotti (nome, codice, modello, tipo, taglia, colore, marca, categoria, stato, data_inserimento, quantita, data_modifica, limite, seriale, prezzo) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssssssisssd", $nome, $codice, $modello, $tipo, $taglia, $colore, $marca, $categoria, $stato, $data_inserimento, $quantita, $data_modifica, $limite, $seriale, $prezzo);

    if ($stmt->execute()) {
        echo "OK";
    } else {
        echo "Errore: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Richiesta non valida.";
}
?>