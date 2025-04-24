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

$userid = $_SESSION['userid'];
$drinktype = $_POST['drinktype'];
$alcoholpercent = $_POST['alcoholpercent'];
$volume_ml = $_POST['volume_ml'];

$sql = "INSERT INTO tbldrinklog (userid, drinktype, alcoholpercent, volume_ml)
        VALUES (?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("isdd", $userid, $drinktype, $alcoholpercent, $volume_ml);

if ($stmt->execute()) {
    echo "Drycken sparades! <a href='add_drink.php'>Lägg till en till</a> eller <a href='view_drinks.php'>Visa logg</a>";
} else {
    echo "Fel: " . $stmt->error;
}




// löst //
// Inkludera promille-beräkning
require_once 'calculate_promille.php';

$promille = calculatePromille($userid, $conn);

// Uppdatera eller lägg till i tblpromille
$check_sql = "SELECT userid FROM tblpromille WHERE userid = ?";
$check_stmt = $conn->prepare($check_sql);
$check_stmt->bind_param("i", $userid);
$check_stmt->execute();
$check_result = $check_stmt->get_result();

if ($check_result->num_rows > 0) {
    // Redan finns - uppdatera
    $update_sql = "UPDATE tblpromille SET promille = ?, updated_at = NOW() WHERE userid = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("di", $promille, $userid);
    $update_stmt->execute();
    $update_stmt->close();
} else {
    // Ny - lägg till
    $insert_sql = "INSERT INTO tblpromille (userid, promille, updated_at) VALUES (?, ?, NOW())";
    $insert_stmt = $conn->prepare($insert_sql);
    $insert_stmt->bind_param("id", $userid, $promille);
    $insert_stmt->execute();
    $insert_stmt->close();
}



$stmt->close();
$conn->close();
?>
