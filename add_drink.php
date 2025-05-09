<?php
session_start();
if (!isset($_SESSION['userid'])) {
    header("Location: loggain.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="sv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lägg till dryck</title>
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
        <h2>Lägg till en dryck</h2>
        <form action="add_drink_submit.php" method="POST">
            <label for="drinktype">Dryckestyp:</label>
            <input type="text" id="drinktype" name="drinktype" required><br>

            <label for="alcoholpercent">Alkoholhalt (%):</label>
            <input type="number" id="alcoholpercent" name="alcoholpercent" step="0.1" required><br>

            <label for="volume_ml">Volym (ml):</label>
            <input type="number" id="volume_ml" name="volume_ml" step="0.1" required><br>

            <input type="submit" value="Spara dryck">
        </form>
        <br>
        <a href="view_drinks.php">Visa mina tidigare drycker</a>
    </main>

    <!-- Footer -->
    <footer>
        <p>&copy; 2025 Promille Tracker</p>
    </footer>
</body>
</html>