<?php
require_once 'func.php';
$conn = getDBConnection();

// Räkna ut tidsintervall för förra dygnet (10:00 till 10:00)
$now = new DateTime("now", new DateTimeZone("UTC"));
$today10 = clone $now;
$today10->setTime(10, 0, 0);

if ($now < $today10) {
    $start = clone $today10;
    $start->modify('-1 day');
    $end = $today10;
} else {
    $start = $today10;
    $end = clone $today10;
    $end->modify('+1 day');
}

$teams = ['Ayia Napa', 'Magaluf'];
$teamAverages = [];

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

    $teamAverages[$team] = $medel !== null ? $medel : 0;
}

// Kolla vilket lag som hade högst snitt
arsort($teamAverages);
$winner = array_key_first($teamAverages);

// Lägg till en poäng till vinnarlaget
if ($winner) {
    $sql = "UPDATE team_points SET points = points + 1 WHERE team = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $winner);
    $stmt->execute();
    $stmt->close();
}

$conn->close();
?>