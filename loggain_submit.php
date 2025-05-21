<?php
require_once 'func.php'; // Inkluderar hjälpfunktioner och startar session samt databasanslutning

$conn = getDBConnection(); // Hämtar aktiv databasanslutning

// Hämta inmatade värden från formuläret, om de finns, annars sätts de till tomma strängar
$namn = $_POST['namn'] ?? '';
$password = $_POST['password'] ?? '';

$login_success = false; // Flagga för att indikera om inloggning lyckades
$message = ""; // Meddelande som visas till användaren

// Kontrollera att både användarnamn och lösenord är ifyllda
if ($namn && $password) {
    // Förbered SQL-fråga för att hämta användare med angivet namn
    $sql = "SELECT id, password, namn, userlevel FROM tbluser WHERE namn = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $namn);
    $stmt->execute();
    $stmt->store_result(); // Lagra resultatet för att kunna kontrollera om någon rad hittades

    // Om minst en rad hittades, dvs användaren finns
    if ($stmt->num_rows > 0) {
        // Hämta data från den hittade raden
        $stmt->bind_result($user_id, $hashed_password, $user_namn, $user_level);
        $stmt->fetch();

        // Kontrollera om lösenordet stämmer (använder säkert hash-verktyg)
        if (password_verify($password, $hashed_password)) {
            // Lösenordet är korrekt, spara relevant info i sessionen
            $_SESSION['userid'] = $user_id;
            $_SESSION['namn'] = $user_namn;
            $_SESSION['userlevel'] = $user_level;

            $login_success = true;
            $message = "Inloggning lyckades!";
        } else {
            // Fel lösenord
            $message = "Felaktigt lösenord. Försök igen.";
        }
    } else {
        // Användarnamnet finns inte i databasen
        $message = "Användaren finns inte. Försök igen.";
    }

    $stmt->close(); // Stänger statement
} else {
    // Något fält är tomt
    $message = "Vänligen fyll i både användarnamn och lösenord.";
}

$conn->close(); // Stänger databasanslutningen
?>

<!DOCTYPE html>
<html lang="sv">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Inloggning</title>
    <link rel="stylesheet" href="style.css" />
    <link rel="icon" type="image/x-icon" href="bilder/favicon/favicon.ico">
<link rel="icon" type="image/png" sizes="32x32" href="bilder/favicon/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="bilder/favicon/favicon-16x16.png">
<link rel="apple-touch-icon" sizes="180x180" href="bilder/favicon/apple-touch-icon.png">
<link rel="manifest" href="bilder/favicon/site.webmanifest">
</head>
<body>
    <!-- Header -->
    <header>
        <div class="header-content">
            <img src="bilder/logotyp.png" alt="Logotyp" />
            <div class="dropdown">
                <button class="menu-toggle" onclick="toggleDropdown()">☰ Meny</button>
                <ul class="dropdown-menu">
                    <li><a href="index.php">Leaderboard</a></li>
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
        <div class="login-submit">
            <h2>Inloggning</h2>
            <p><?= htmlspecialchars($message) ?></p>

            <?php if ($login_success): ?>
                <a href="index.php">Till leaderboarden</a>
                <a href="loggaut.php">Logga ut</a>
            <?php else: ?>
                <a href="loggain.php">Försök igen</a>
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
