<?php
session_start();
if (!isset($_SESSION['userid'])) {
    header("Location: login.php");
    exit;
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "promille";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Kunde inte ansluta: " . $conn->connect_error);
}

// Hämta alla användare
$sql = "SELECT u.id, u.namn, p.promille 
        FROM tbluser u 
        LEFT JOIN tblpromille p ON u.id = p.userid
        ORDER BY u.namn ASC";

$result = $conn->query($sql);

echo "<h2>Lista över användare och deras promille</h2>";
echo "<a href='add_drink.php'>Tillbaka till Lägg till dryck</a> | <a href='logout.php'>Logga ut</a><br><br>";

if ($result->num_rows > 0) {
    echo "<ul>";
    while ($row = $result->fetch_assoc()) {
        $user_id = $row['id'];
        $namn = htmlspecialchars($row['namn']);
        $promille = is_null($row['promille']) ? "–" : number_format($row['promille'], 2) . " ‰";

        echo "<li><a href='view_drinks.php?userid=$user_id'>🍻 $namn ($promille)</a></li>";
    }
    echo "</ul>";
} else {
    echo "Inga användare hittades.";
}

$conn->close();
?>
