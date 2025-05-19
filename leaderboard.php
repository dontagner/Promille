<?php
session_start();
?>
<!DOCTYPE html>
<html lang="sv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Promille-leaderboard</title>
    <link rel="stylesheet" href="style.css"> <!-- Lägg till din CSS-fil här -->
    <script>
    function toggleDropdown() {
    const dropdown = document.querySelector(".dropdown");
    dropdown.classList.toggle("show");
}


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
                const leaderboardBody = document.getElementById("leaderboard-body");
                leaderboardBody.innerHTML = xhr.responseText;

                // Tilldela färger till de tre första placeringarna
                const rows = leaderboardBody.querySelectorAll("tr");
                if (rows[0]) rows[0].classList.add("gold");
                if (rows[1]) rows[1].classList.add("silver");
                if (rows[2]) rows[2].classList.add("bronze");

                // Sätt "senast uppdaterad"
                const now = new Date();
                const formatted = now.toLocaleTimeString("sv-SE");
                document.getElementById("last-updated").innerText = "Senast uppdaterad: " + formatted;
            }
        };
        xhr.send();
    }



function loadTeamLeaderboard() {
    const xhr = new XMLHttpRequest();
    xhr.open("GET", "get_team_leaderboard.php", true);
    xhr.onload = function () {
        if (xhr.status === 200) {
            document.getElementById("team-leaderboard-body").innerHTML = xhr.responseText;
        }
    };
    xhr.send();
}

window.onload = function () {
    updatePromille();
    loadLeaderboard();
    loadTeamLeaderboard();
    setInterval(() => {
        updatePromille();
        loadLeaderboard();
        loadTeamLeaderboard();
    }, 30000);
};
    
    </script>
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
        <div class="leaderboard">
            <h2>Leaderboard</h2>

            <table>
                <thead>
                    <tr>
                        <th>Placering</th>
                        <th>Namn</th>
                        <th>Promille</th>
                        <th>Team</th>
                    </tr>
                </thead>
                <tbody id="leaderboard-body">
                    <tr><td colspan="4">Laddar data...</td></tr>
                </tbody>
            </table>

            <p id="last-updated" class="last-updated">Senast uppdaterad: laddar...</p>
        </div>



            <!-- Team Leaderboard -->
    <div class="team-leaderboard">
        <h2>Team-leaderboard</h2>
        <table>
            <thead>
                <tr>
                    <th>Team</th>
                    <th>Snittpromille</th>
                </tr>
            </thead>
            <tbody id="team-leaderboard-body">
                <tr><td colspan="2">Laddar data...</td></tr>
            </tbody>
        </table>
    </div>
    </main>

    <!-- Footer -->
    <footer>
        <p>&copy; 2025 Promille Tracker</p>
    </footer>
</body>
</html>