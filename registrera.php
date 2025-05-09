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
    <div class="register-form">
        <h2>Registrera dig</h2>
        <form action="registrera_submit.php" method="POST">
            <label for="namn">Namn:</label>
            <input type="text" id="namn" name="namn" required>

            <label for="password">Lösenord:</label>
            <input type="password" id="password" name="password" required>

            <label for="weight">Vikt (kg):</label>
            <input type="number" id="weight" step="0.1" name="weight" required>

            <label for="height">Längd (cm):</label>
            <input type="number" id="height" step="0.1" name="height" required>

            <label for="team">Ditt team:</label>
            <select id="team" name="team" required>
                <option value="">-- Välj ett team --</option>
                <option value="Magaluf">Team Magaluf</option>
                <option value="Aiya Napa">Team Aiya Napa</option>
            </select>

            <input type="submit" value="Registrera">
        </form>
    </div>
</main>

<!-- Footer -->
<footer>
    <p>&copy; 2025 Promille Tracker</p>
</footer>
</body>
</html>
