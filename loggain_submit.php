<?php
session_start(); // Startar sessionen så vi kan använda sessionvariabler

$servername = "localhost";
$username = "root"; // ändra vid behov
$password = "";     // ändra vid behov
$dbname = "promille"; // Er databasnamn

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Kunde inte ansluta: " . $conn->connect_error);
}

$namn = $_POST['namn'];
$password = $_POST['password'];

// Hämta användarens data från databasen
$sql = "SELECT id, password, namn, userlevel FROM tbluser WHERE namn = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $namn); // Bind parametrar
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    // Hämta användarens id, lösenord, namn och userlevel från databasen
    $stmt->bind_result($user_id, $hashed_password, $user_namn, $user_level);
    $stmt->fetch();

    // Kontrollera om det angivna lösenordet matchar det hashade lösenordet
    if (password_verify($password, $hashed_password)) {
        // Lösenordet är korrekt, sätt användarens info i sessionen
        $_SESSION['userid'] = $user_id;
        $_SESSION['namn'] = $user_namn;
        $_SESSION['userlevel'] = $user_level;
        
        echo "Inloggning lyckades! <a href='index.php'>Till startsidan</a> logga ut <a href='loggaut.php'>Här</a>";
    } else {
        echo "Felaktigt lösenord. Försök igen.";
    }
} else {
    echo "Användaren finns inte. Försök igen.";
}

$stmt->close();
$conn->close();
?>
