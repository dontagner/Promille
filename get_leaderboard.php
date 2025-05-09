<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "promille";

// Anslut till databasen
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Kunde inte ansluta: " . $conn->connect_error);
}

// Uppdaterad SQL-fråga för att inkludera team
$sql = "SELECT u.namn, p.promille, u.team
        FROM tbluser u
        JOIN tblpromille p ON u.id = p.userid
        ORDER BY p.promille DESC";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
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