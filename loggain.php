<?php
session_start();
?>
<!DOCTYPE html>
<html lang="sv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logga in</title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" type="image/x-icon" href="bilder/favicon/favicon.ico">
<link rel="icon" type="image/png" sizes="32x32" href="bilder/favicon/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="bilder/favicon/favicon-16x16.png">
<link rel="apple-touch-icon" sizes="180x180" href="bilder/favicon/apple-touch-icon.png">
<link rel="manifest" href="bilder/favicon/site.webmanifest">
</head>
<body>
<header>
    <div class="header-content">
        <img src="bilder/logotyp.png" alt="Logotyp">
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
    
<main>
    <div class="login-form">
        <h2>Logga in</h2>
        <form action="loggain_submit.php" method="POST">
            <label for="namn">Förnamn och Efternamn:</label>
            <input type="text" id="namn" name="namn" required>

            <label for="password">Lösenord:</label>
            <input type="password" id="password" name="password" required>

            <input type="submit" value="Logga in">
        </form>
        <br>

        <!-- Länk till registreringssida -->
        <p>Har du inget konto? <a href="registrera.php">Registrera dig här</a>.</p>
    </div>
</main>

<!-- Footer -->
<footer>
    <p>&copy; 2025 Promille Tracker</p>
</footer>

<script>
    function toggleDropdown() {
        const dropdown = document.querySelector(".dropdown");
        dropdown.classList.toggle("show");
    }
</script>
</body>
</html>
