<?php
require_once 'func.php';
$conn = getDBConnection();

// Hämta högsta promille för varje användare de senaste 24 timmarna
$sql = "
    SELECT u.namn, MAX(l.promille) AS max_promille, u.team
    FROM tbluser u
    JOIN tblpromillelog l ON u.id = l.userid
    WHERE l.updated_at >= UTC_TIMESTAMP() - INTERVAL 24 HOUR
    GROUP BY u.id
    ORDER BY max_promille DESC
    LIMIT 3
";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    $rank = 1;
    while ($row = $result->fetch_assoc()) {
        $namn = htmlspecialchars($row['namn']);
        $promille = number_format($row['max_promille'], 2);
        $team = htmlspecialchars($row['team']) ?: "Inget team";
        echo "<tr>";
        echo "<td>$rank</td>";
        echo "<td>$namn</td>";
        echo "<td>$promille ‰</td>";
        echo "<td>$team</td>";
        echo "</tr>";
        $rank++;
    }
} else {
    echo "<tr><td colspan='4'>Inga toppvärden senaste 24 timmarna</td></tr>";
}

$conn->close();
?>