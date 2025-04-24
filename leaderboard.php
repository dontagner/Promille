<?php
session_start();
if (!isset($_SESSION['userid'])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="sv">
<head>
    <meta charset="UTF-8">
    <title>Promille-leaderboard</title>
    <script>
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
            loadLeaderboard();
            setInterval(loadLeaderboard, 30000);
        };
    </script>
</head>
<body>
    <h2>🍻 Promille-leaderboard</h2>
    <a href='add_drink.php'>Lägg till dryck</a> |
    <a href='user_list.php'>Visa användare</a> |
    <a href='logout.php'>Logga ut</a>
    <br><br>

    <table border='1' cellpadding='5'>
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

    <p id="last-updated" style="margin-top:10px; font-style: italic; color: gray;">Senast uppdaterad: laddar...</p>
</body>
</html>
