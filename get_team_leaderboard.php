<?php
require_once 'func.php';
$conn = getDBConnection();

$allTeams = ['Ayia Napa', 'Magaluf'];
$teamData = [];

// Hämta snittpromille för båda teamen
$sql = "SELECT u.team, AVG(p.promille) AS avg_promille
        FROM tbluser u
        JOIN tblpromille p ON u.id = p.userid
        WHERE u.team IN ('Ayia Napa', 'Magaluf')
        GROUP BY u.team";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $teamData[$row['team']] = number_format($row['avg_promille'], 2);
    }
}

// Sortera efter högst snittpromille
arsort($teamData);

// Skriv ut teamen i sorterad ordning (högst promille först)
$rank = 1;
$printed = [];
foreach ($teamData as $team => $avg) {
    $class = '';
    if ($rank == 1) $class = 'gold';
    if ($rank == 2) $class = 'silver';
    echo "<tr class=\"$class\"><td>$team</td><td>$avg ‰</td></tr>";
    $printed[] = $team;
    $rank++;
}

// Om något team saknas i $teamData, visa det sist med 0.00
foreach ($allTeams as $team) {
    if (!in_array($team, $printed)) {
        $class = ($rank == 1) ? 'gold' : (($rank == 2) ? 'silver' : '');
        echo "<tr class=\"$class\"><td>$team</td><td>0.00 ‰</td></tr>";
        $rank++;
    }
}

$conn->close();
?>