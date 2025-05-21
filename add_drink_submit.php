<?php
require_once 'func.php'; // Inkluderar hjälpfunktioner, startar session och skapar databasanslutning

// Kontrollera att användaren är inloggad, annars omdirigera till inloggningssidan
if (!isset($_SESSION['userid'])) {
    header("Location: loggain.php");
    exit;
}

$conn = getDBConnection(); // Hämta databasanslutningen

// Hämta data från formuläret (POST-data)
$userid = $_SESSION['userid'];
$drinktype = $_POST['drinktype'];
$alcoholpercent = $_POST['alcoholpercent'];
$volume_ml = $_POST['volume_ml'];
$utc_time = (new DateTime('now', new DateTimeZone('UTC')))->format('Y-m-d H:i:s');

// Förbered SQL-sats för att lägga till drycken i loggen
$sql = "INSERT INTO tbldrinklog (userid, drinktype, alcoholpercent, volume_ml, drinktimestamp)
        VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("isdds", $userid, $drinktype, $alcoholpercent, $volume_ml, $utc_time); // i = int, s = string, d = double
$success = $stmt->execute(); // Kör frågan

// Skapa ett meddelande beroende på om insättningen lyckades
$message = $success ? "Drycken sparades!" : "Fel: " . $stmt->error;

// Beräkna aktuell promille efter att drycken lagts till
require_once 'calculate_promille.php';
$promille = calculatePromille($userid, $conn);

// Kontrollera om användaren redan finns i promille-tabellen
$check_sql = "SELECT userid FROM tblpromille WHERE userid = ?";
$check_stmt = $conn->prepare($check_sql);
$check_stmt->bind_param("i", $userid);
$check_stmt->execute();
$check_stmt->store_result();

// Uppdatera promille om posten finns, annars skapa en ny
if ($check_stmt->num_rows > 0) {
    // Användaren finns redan – uppdatera promillevärdet
    $update_sql = "UPDATE tblpromille SET promille = ?, updated_at = NOW() WHERE userid = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("di", $promille, $userid);
    $update_stmt->execute();
    $update_stmt->close();
} else {
    // Ny användare – skapa ny post
    $insert_sql = "INSERT INTO tblpromille (userid, promille, updated_at) VALUES (?, ?, NOW())";
    $insert_stmt = $conn->prepare($insert_sql);
    $insert_stmt->bind_param("id", $userid, $promille);
    $insert_stmt->execute();
    $insert_stmt->close();
}

// Stäng alla öppna statements och anslutning
$stmt->close();
$check_stmt->close();
$conn->close();
?>


<!DOCTYPE html>
<html lang="sv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lägg till dryck</title>
    <link rel="stylesheet" href="style.css"> 
    <link rel="icon" type="image/x-icon" href="bilder/favicon/favicon.ico">
<link rel="icon" type="image/png" sizes="32x32" href="bilder/favicon/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="bilder/favicon/favicon-16x16.png">
<link rel="apple-touch-icon" sizes="180x180" href="bilder/favicon/apple-touch-icon.png">
<link rel="manifest" href="bilder/favicon/site.webmanifest">
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
        <div class="add-drink-submit">
        <h2>Lägg till dryck</h2>
        <p><?php echo htmlspecialchars($message); ?></p>

        <?php if ($success): ?>
            <p><a href="add_drink.php">Lägg till en till dryck</a></p>
            <p><a href="view_drinks.php">Visa mina tidigare drycker</a></p>
            <p><a href="index.php">Gå till leaderboarden</a></p>
        <?php else: ?>
            <p><a href="add_drink.php">Försök igen</a></p>
        <?php endif; ?>
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