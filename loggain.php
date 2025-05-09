<!DOCTYPE html>
<html lang="sv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logga in</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
    <img src="bilder/logotyp.png" alt="">
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
    
    <main>
        <div class="login-form">
            <h2>Logga in</h2>
            <form action="loggain_submit.php" method="POST">
                <label for="namn">Namn:</label>
                <input type="text" id="namn" name="namn" required>

                <label for="password">Lösenord:</label>
                <input type="password" id="password" name="password" required>

                <input type="submit" value="Logga in">
            </form>
        </div>
    </main>
        <!-- Footer -->
    <footer>
        <p>&copy; 2025 Promille Tracker</p>
    </footer>
</body>
</html>
