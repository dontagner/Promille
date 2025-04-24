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

// Om ett userid skickas i URL:en använder vi det, annars ens egna
$userid_to_view = isset($_GET['userid']) ? (int)$_GET['userid'] : $_SESSION['userid'];

// Hämta användarens namn för rubrik
$name_sql = "SELECT namn FROM tbluser WHERE id = ?";
$name_stmt = $conn->prepare($name_sql);
$name_stmt->bind_param("i", $userid_to_view);
$name_stmt->execute();
$name_result = $name_stmt->get_result();
$user_name = ($name_result->num_rows > 0) ? $name_result->fetch_assoc()['namn'] : "Okänd";

$sql = "SELECT drinktype, alcoholpercent, volume_ml, drinktimestamp 
        FROM tbldrinklog 
        WHERE userid = ? 
        ORDER BY drinktimestamp DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userid_to_view);
$stmt->execute();
$result = $stmt->get_result();

echo "<h2>Dryckeslogg för användare: <strong>$user_name</strong></h2>";
echo "<a href='add_drink.php'>Tillbaka till lägg till dryck</a> | <a href='logout.php'>Logga ut</a> | <a href='user_list.php'>Kolla alla användare</a><br><br>";

if ($result->num_rows > 0) {
    echo "<table border='1'>
            <tr>
                <th>Dryckestyp</th>
                <th>Alkohol%</th>
                <th>Volym (ml)</th>
                <th>Tid</th>
            </tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['drinktype']}</td>
                <td>{$row['alcoholpercent']}</td>
                <td>{$row['volume_ml']}</td>
                <td>{$row['drinktimestamp']}</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "Inga drycker hittades för denna användare.";
}

$stmt->close();
$conn->close();
?>
