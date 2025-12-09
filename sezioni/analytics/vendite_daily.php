<?php
include_once '../../dbconfig.php';

$oggi = date('Y-m-d');
$query = "SELECT HOUR(data) as ora, SUM(quantita) as totale
          FROM vendite
          WHERE DATE(data) = CURDATE()
            AND HOUR(data) BETWEEN 9 AND 19
          GROUP BY ora
          ORDER BY ora";

$result = $conn->query($query);
$venditePerOra = [];
while ($row = $result->fetch_assoc()) {
    $venditePerOra[(int)$row['ora']] = (int)$row['totale'];
}
$dati = [];
for ($ora = 9; $ora <= 19; $ora++) {
    $dati[] = [
        "ora" => sprintf('%02d:00', $ora),
        "totale" => $venditePerOra[$ora] ?? 0
    ];
}

header('Content-Type: application/json');
echo json_encode($dati);
?>