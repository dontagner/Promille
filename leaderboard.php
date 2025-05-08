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
    <title>Promille-leaderboard</title>
    <link rel="stylesheet" href="style.css"> <!-- Lägg till din CSS-fil här -->
    <script>
    function updatePromille() {
        const xhr = new XMLHttpRequest();
        xhr.open("GET", "update_promille.php", true);
        xhr.onload = function () {
            if (xhr.status === 200) {
                console.log("Promille uppdaterad: " + xhr.responseText);
            }
        };
        xhr.send();
    }

    function loadLeaderboard() {
        const xhr = new XMLHttpRequest();
        xhr.open("GET", "get_leaderboard.php", true);
        xhr.onload = function () {
            if (xhr.status === 200) {
                document.getElementById("leaderboard-body").innerHTML = xhr.responseText;

                // Sätt "senast uppdaterad"
                const now = new Date();
                const formatted = now.toLocaleTimeString("sv-SE");
                document.getElementById("last-updated").innerText = "Senast uppdaterad: " + formatted;
            }
        };
        xhr.send();
    }

    window.onload = function () {
        updatePromille(); // Uppdatera promille direkt vid sidladdning
        loadLeaderboard();
        setInterval(() => {
            updatePromille();
            loadLeaderboard();
        }, 30000); // Kör var 30:e sekund
    };
    </script>
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
        <h2>🍻 Promille-leaderboard</h2>

        <table>
            <thead>
                <tr>
                    <th>Placering</th>
                    <th>Namn</th>
                    <th>Promille</th>
                    <th>Senast druckit</th>
                </tr>
            </thead>
            <tbody id="leaderboard-body">
                <tr><td colspan="4">Laddar data...</td></tr>
            </tbody>
        </table>

        <p id="last-updated" class="last-updated">Senast uppdaterad: laddar...</p>
    </main>

    <!-- Footer -->
    <footer>
        <p>&copy; 2025 Promille Tracker</p>
    </footer>
</body>
</html>