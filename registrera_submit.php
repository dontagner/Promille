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

$success = $stmt->execute();
$message = $success ? "Registrering lyckades!" : "Fel: " . $stmt->error;

$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="sv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrering</title>
    <link rel="stylesheet" href="style.css"> <!-- Lägg till din CSS-fil här -->
</head>
<body>
    <!-- Header -->
    <header>
        <div class="logo">Promille Tracker</div>
        <nav>
            <ul>
                <li><a href="home.php">Hem</a></li>
                <li><a href="leaderboard.php">Leaderboard</a></li>
                <li><a href="add_drink.php">Lägg till dryck</a></li>
                <li><a href="user_list.php">Kolla alla användare</a></li>
                <li><a href="loggaut.php">Logga ut</a></li>
            </ul>
        </nav>
    </header>

    <!-- Main Content -->
    <main>
        <h2>Registrering</h2>
        <p><?php echo htmlspecialchars($message); ?></p>
        <?php if ($success): ?>
            <p><a href="loggain.php">Logga in här</a></p>
        <?php else: ?>
            <p><a href="registrera.php">Försök igen</a></p>
        <?php endif; ?>
    </main>

    <!-- Footer -->
    <footer>
        <p>&copy; 2025 Promille Tracker</p>
    </footer>
</body>
</html>