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

$login_success = false;
$message = "";

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

        $login_success = true;
        $message = "Inloggning lyckades!";
    } else {
        $message = "Felaktigt lösenord. Försök igen.";
    }
} else {
    $message = "Användaren finns inte. Försök igen.";
}

$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="sv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inloggning</title>
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
        <h2>Inloggning</h2>
        <p><?php echo htmlspecialchars($message); ?></p>

        <?php if ($login_success): ?>
            <p><a href="home.php">Till startsidan</a></p>
            <p><a href="leaderboard.php">Till leaderboarden</a></p>
            <p><a href="loggaut.php">Logga ut</a></p>
        <?php else: ?>
            <p><a href="login.php">Försök igen</a></p>
        <?php endif; ?>
    </main>

    <!-- Footer -->
    <footer>
        <p>&copy; 2025 Promille Tracker</p>
    </footer>
</body>
</html>