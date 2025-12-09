<?php
// Mostra errori
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Connessione DB
include '../../dbconfig.php';

// Verifica se è stato passato un ID valido
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = intval($_GET['id']);

    // Esegui DELETE
    $sql = "DELETE FROM prodotti WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
        // Redirect con successo
        header("Location: ../../index.php");
        exit();
    } else {
        echo "Errore nella cancellazione: " . $conn->error;
    }
} else {
    echo "ID non valido.";
}

$conn->close();
?>