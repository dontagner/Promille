<?php
require_once 'func.php';
$conn = getDBConnection();

// Räkna ut tidsintervall: idag 10:00 till imorgon 10:00 (eller igår 10:00 till idag 10:00 om klockan är före 10)
$now = new DateTime("now", new DateTimeZone("UTC"));
$today10 = clone $now;
$today10->setTime(10, 0, 0);

if ($now < $today10) {
    // Om klockan är före 10:00, ta igår 10:00 till idag 10:00
    $start = clone $today10;
    $start->modify('-1 day');
    $end = $today10;
} else {
    // Annars idag 10:00 till imorgon 10:00
    $start = $today10;
    $end = clone $today10;
    $end->modify('+1 day');
}

$teams = ['Ayia Napa', 'Magaluf'];
foreach ($teams as $team) {
    $sql = "SELECT AVG(avg_promille) AS medel
            FROM team_avg_log
            WHERE team = ? AND log_time >= ? AND log_time < ?";
    $stmt = $conn->prepare($sql);
    $startStr = $start->format('Y-m-d H:i:s');
    $endStr = $end->format('Y-m-d H:i:s');
    $stmt->bind_param("sss", $team, $startStr, $endStr);
    $stmt->execute();
    $stmt->bind_result($medel);
    $stmt->fetch();
    $stmt->close();

    $medel = $medel !== null ? number_format($medel, 2) : "0.00";
    echo "<tr><td>$team</td><td>$medel ‰</td></tr>";
}
$conn->close();
?>