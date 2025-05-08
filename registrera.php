<!DOCTYPE html>
<html lang="sv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrera dig</title>
    <link rel="stylesheet" href="style.css">
    
</head>
<body>
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

    <h2>Registrera dig</h2>
    <form action="registrera_submit.php" method="POST">
        Namn: <input type="text" name="namn" required><br>
        Lösenord: <input type="password" name="password" required><br>
        Vikt (kg): <input type="number" step="0.1" name="weight" required><br>
        Längd (cm): <input type="number" step="0.1" name="height" required><br>
        <input type="submit" value="Registrera">
    </form>

        <!-- Footer -->
    <footer>
        <p>&copy; 2025 Promille Tracker</p>
    </footer>
</body>
</html>
