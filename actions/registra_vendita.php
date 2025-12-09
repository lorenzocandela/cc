<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include '../dbconfig.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // form
    $quantita = intval($_POST['sales-qty']);
    $seriale = $_POST['sales-serial'];

    // query
    $stmt = $conn->prepare("INSERT INTO vendite (seriale, quantita) VALUES (?, ?)");
    $stmt->bind_param("si", $seriale, $quantita);

    if ($stmt->execute()) {
        echo "OK";
    } else {
        echo "Errore: " . $stmt->error;
    }

    // aggiorno dispo
    $checkStmt = $conn->prepare("SELECT COUNT(*) FROM prodotti WHERE seriale = ?");
    $checkStmt->bind_param("s", $seriale);
    $checkStmt->execute();
    $checkStmt->bind_result($rowCount);
    $checkStmt->fetch();

    if ($rowCount > 0) {
        $updateStmt = $conn->prepare("UPDATE prodotti SET quantita = quantita - ? WHERE seriale = ?");
        $updateStmt->bind_param("is", $quantita, $seriale);
    
        if ($updateStmt->execute()) {
            //
        } else {
            $errorLog = "Errore aggiornamento prodotto seriale: $seriale - " . $updateStmt->error . "\n";
            file_put_contents('../logs/error_log_vendite.txt', $errorLog, FILE_APPEND);
        }
    
        $updateStmt->close(); // ← solo se esiste
    } else {
        $errorLog = "Prodotto non trovato per seriale: $seriale\n";
        file_put_contents('../logs/error_log_vendite.txt', $errorLog, FILE_APPEND);
    }    

    $checkStmt->close();
    $stmt->close();
    $conn->close();
} else {
    echo "Richiesta non valida.";
}
?>