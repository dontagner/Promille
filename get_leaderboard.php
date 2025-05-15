<?php
require_once 'func.php';  // Inkluderar sessionstart och getDBConnection()

$conn = getDBConnection();

$sql = "SELECT u.namn, p.promille, u.team
        FROM tbluser u
        JOIN tblpromille p ON u.id = p.userid
        ORDER BY p.promille DESC";

$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    $rank = 1; // Placeringsräknare
    while ($row = $result->fetch_assoc()) {
        $namn = htmlspecialchars($row['namn']);
        $promille = number_format($row['promille'], 2);
        $team = htmlspecialchars($row['team']) ?: "Inget team"; // Visa "Inget team" om team är null

        echo "<tr>";
        echo "<td>$rank</td>"; // Placeringskolumn
        echo "<td>$namn</td>"; // Namnkolumn
        echo "<td>$promille ‰</td>"; // Promillekolumn
        echo "<td>$team</td>"; // Teamkolumn
        echo "</tr>";

        $rank++;
    }
} else {
    echo "<tr><td colspan='4'>Inga promillevärden registrerade</td></tr>";
}

$conn->close();
?>
