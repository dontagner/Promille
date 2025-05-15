<?php
session_start();
require_once 'func.php'; // Inkluderar getDBConnection()

$conn = getDBConnection();

// Registreringskod – byt till din hemliga kod här:
$correct_code = "hemligkod2025";

// Hämta och sanera formulärdata
$namn = trim($_POST['namn'] ?? '');
$input_code = trim($_POST['regcode'] ?? '');
$password = isset($_POST['password']) ? password_hash($_POST['password'], PASSWORD_DEFAULT) : '';
$weight = floatval($_POST['weight'] ?? 0);
$height = floatval($_POST['height'] ?? 0);
$team = $_POST['team'] ?? '';
$userlevel = 10; // Standardnivå för nya användare

// Kontrollera att registreringskoden är korrekt
if ($input_code !== $correct_code) {
    $message = "Felaktig registreringskod. Kontakta admin för att få rätt kod.";
    $success = false;
} else {
    // Försök skapa användare
    $sql = "INSERT INTO tbluser (namn, password, weight, height, alkoholvolym, userlevel, team)
            VALUES (?, ?, ?, ?, 0, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssdiis", $namn, $password, $weight, $height, $userlevel, $team);
    $success = $stmt->execute();
    $message = $success ? "Registrering lyckades!" : "Fel: " . $stmt->error;
    $stmt->close();
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="sv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrering</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<!-- Header -->
<header>
    <div class="header-content">
        <img src="bilder/logotyp.png" alt="Logotyp">
        <div class="dropdown">
            <button class="menu-toggle" onclick="toggleDropdown()">☰ Meny</button>
            <ul class="dropdown-menu">
                <li><a href="leaderboard.php">Leaderboard</a></li>
                <li><a href="add_drink.php">Lägg till dryck</a></li>
                <li><a href="user_list.php">Kolla alla användare</a></li>
                <?php if (isset($_SESSION['userid'])): ?>
                    <li><a href="loggaut.php">Logga ut</a></li>
                <?php else: ?>
                    <li><a href="loggain.php">Logga in</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</header>

<!-- Main Content -->
<main>
    <div class="register-submit">
        <h2>Registrering</h2>
        <p><?= htmlspecialchars($message) ?></p>

        <?php if ($success): ?>
            <a href="loggain.php">Logga in här</a>
        <?php else: ?>
            <a href="registrera.php">Försök igen</a>
        <?php endif; ?>
    </div>
</main>

<!-- Footer -->
<footer>
    <p>&copy; 2025 Promille Tracker</p>
</footer>

<script>
    function toggleDropdown() {
        document.querySelector(".dropdown").classList.toggle("show");
    }
</script>
</body>
</html>
