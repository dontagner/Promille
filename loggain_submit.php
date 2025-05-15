<?php
require_once 'func.php'; // Startar session + ger mysqli-anslutning

$conn = getDBConnection();

$namn = $_POST['namn'] ?? '';
$password = $_POST['password'] ?? '';

$login_success = false;
$message = "";

if ($namn && $password) {
    $sql = "SELECT id, password, namn, userlevel FROM tbluser WHERE namn = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $namn);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($user_id, $hashed_password, $user_namn, $user_level);
        $stmt->fetch();

        if (password_verify($password, $hashed_password)) {
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
} else {
    $message = "Vänligen fyll i både användarnamn och lösenord.";
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="sv">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Inloggning</title>
    <link rel="stylesheet" href="style.css" />
</head>
<body>
    <!-- Header -->
    <header>
        <div class="header-content">
            <img src="bilder/logotyp.png" alt="Logotyp" />
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
        <div class="login-submit">
            <h2>Inloggning</h2>
            <p><?= htmlspecialchars($message) ?></p>

            <?php if ($login_success): ?>
                <a href="leaderboard.php">Till leaderboarden</a>
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
