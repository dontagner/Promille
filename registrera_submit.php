<?php
$servername = "localhost";
$username = "root"; // ändra vid behov
$password = "";     // ändra vid behov
$dbname = "promille"; // byt till er databas

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Kunde inte ansluta: " . $conn->connect_error);
}

$namn = $_POST['namn'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
$weight = $_POST['weight'];
$height = $_POST['height'];
$userlevel = 10; // standard för nya konton

$sql = "INSERT INTO tbluser (namn, password, weight, height, alkoholvolym, userlevel)
        VALUES (?, ?, ?, ?, 0, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ssdii", $namn, $password, $weight, $height, $userlevel);

if ($stmt->execute()) {
    echo "Registrering lyckades! <a href='loggain.php'>Logga in här</a>";
} else {
    echo "Fel: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
