<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "promille";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Kunde inte ansluta: " . $conn->connect_error);
}

$sql = "SELECT u.namn, p.promille, p.updated_at 
        FROM tbluser u
        JOIN tblpromille p ON u.id = p.userid
        ORDER BY p.promille DESC";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $rank = 1;
    while ($row = $result->fetch_assoc()) {
        $namn = htmlspecialchars($row['namn']);
        $promille = number_format($row['promille'], 2);
        $updated = $row['updated_at'];

        echo "<tr>";
        echo "<td>$rank</td>";
        echo "<td>$namn</td>";
        echo "<td>$promille ‰</td>";
        echo "<td>$updated</td>";
        echo "</tr>";

        $rank++;
    }
} else {
    echo "<tr><td colspan='4'>Inga promillevärden registrerade</td></tr>";
}

$conn->close();
?>
