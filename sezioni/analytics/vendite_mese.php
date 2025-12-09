<?php
include_once '../../dbconfig.php';
$query = "SELECT DATE(data) as giorno, SUM(quantita) as totale
          FROM vendite
          WHERE MONTH(data) = MONTH(CURDATE()) AND YEAR(data) = YEAR(CURDATE())
          GROUP BY giorno
          ORDER BY giorno";

$result = $conn->query($query);
$venditeAssoc = [];
while ($row = $result->fetch_assoc()) {
    $venditeAssoc[$row["giorno"]] = (int)$row["totale"];
}
$oggi = new DateTime();
$inizioMese = new DateTime($oggi->format('Y-m-01'));
$fineMese = new DateTime();
$giorni = [];

$periodo = new DatePeriod($inizioMese, new DateInterval('P1D'), $fineMese->modify('+1 day'));

$periodo = new DatePeriod($inizioMese, new DateInterval('P1D'), $fineMese->modify('+1 day'));

foreach ($periodo as $giorno) {
    $data = $giorno->format('Y-m-d');
    $giorni[] = [
        "giorno" => $data,
        "totale" => $venditeAssoc[$data] ?? 0
    ];
}
header('Content-Type: application/json');
echo json_encode($giorni);
?>
