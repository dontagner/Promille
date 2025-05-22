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
    <link rel="icon" type="image/x-icon" href="bilder/favicon/favicon.ico">
<link rel="icon" type="image/png" sizes="32x32" href="bilder/favicon/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="bilder/favicon/favicon-16x16.png">
<link rel="apple-touch-icon" sizes="180x180" href="bilder/favicon/apple-touch-icon.png">
<link rel="manifest" href="bilder/favicon/site.webmanifest">
    <script>
    // JavaScript för att visa/dölja "Annat"-fältet
    function toggleOtherDrink() {
        const drinkSelect = document.getElementById("drinktype");
        const otherDrinkDiv = document.getElementById("otherDrinkDiv");
        if (drinkSelect.value === "Annat") {
            otherDrinkDiv.style.display = "block";
        } else {
            otherDrinkDiv.style.display = "none";
            document.getElementById("otherdrink").value = ""; // Rensa om fältet döljs
        }
    }
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
                <li><a href="index.php">Leaderboard</a></li>
                <li><a href="add_drink.php">Lägg till dryck</a></li>
                <li><a href="user_list.php">Kolla alla användare</a></li>
                <li><a href="loggaut.php">Logga ut</a></li>
            </ul>
        </div>
    </div>
</header>

    <!-- Main Content -->
    <main>
        <div class="add-drink-form">
        <h2>Lägg till en dryck</h2>
        <form action="add_drink_submit.php" method="POST">
            <label for="drinktype">Dryckestyp:</label>
            <select id="drinktype" name="drinktype" onchange="toggleOtherDrink()" required>
                <option value="Cider">Cider</option>
                <option value="Öl">Öl</option>
                <option value="Shot">Shot</option>
                <option value="Drink">Drink</option>
                <option value="Annat">Annat</option>
            </select><br>

            <div id="otherDrinkDiv" style="display:none;">
                <label for="otherdrink">Ange annan dryck:</label>
                <input type="text" id="otherdrink" name="otherdrink"><br>
            </div>

            <label for="alcoholpercent">Alkoholhalt (%):</label>
            <input type="number" id="alcoholpercent" name="alcoholpercent" step="0.1" min="0" max="70.0" required><br>

            <label for="volume_ml">Volym (ml):</label>
            <input type="number" id="volume_ml" name="volume_ml" step="0.1"  min="1" max="2000" required><br>

            <input type="submit" value="Spara dryck">
        </form>
        <br>
        <a href="view_drinks.php">Visa mina tidigare drycker</a>
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
<script>
var nowUTC = new Date().toISOString().slice(0, 19).replace('T', ' ');
// Här kan du t.ex. sätta värdet i ett dolt formulärfält:
document.addEventListener('DOMContentLoaded', function() {
    var utcInput = document.getElementById('utc_time');
    if (utcInput) {
        utcInput.value = nowUTC;
    }
});
</script>
</body>
</html>
