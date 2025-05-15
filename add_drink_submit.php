<?php
require_once 'func.php'; // Startar session + mysqli-anslutning

if (!isset($_SESSION['userid'])) {
    header("Location: loggain.php");
    exit;
}

$conn = getDBConnection();

$userid = $_SESSION['userid'];
$drinktype = $_POST['drinktype'];
$alcoholpercent = $_POST['alcoholpercent'];
$volume_ml = $_POST['volume_ml'];

$sql = "INSERT INTO tbldrinklog (userid, drinktype, alcoholpercent, volume_ml)
        VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("isdd", $userid, $drinktype, $alcoholpercent, $volume_ml);
$success = $stmt->execute();

$message = $success ? "Drycken sparades!" : "Fel: " . $stmt->error;

require_once 'calculate_promille.php';

$promille = calculatePromille($userid, $conn);

// Kontrollera om userid finns i tblpromille
$check_sql = "SELECT userid FROM tblpromille WHERE userid = ?";
$check_stmt = $conn->prepare($check_sql);
$check_stmt->bind_param("i", $userid);
$check_stmt->execute();
$check_stmt->store_result();

if ($check_stmt->num_rows > 0) {
    // Uppdatera befintlig post
    $update_sql = "UPDATE tblpromille SET promille = ?, updated_at = NOW() WHERE userid = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("di", $promille, $userid);
    $update_stmt->execute();
    $update_stmt->close();
} else {
    // Lägg till ny post
    $insert_sql = "INSERT INTO tblpromille (userid, promille, updated_at) VALUES (?, ?, NOW())";
    $insert_stmt = $conn->prepare($insert_sql);
    $insert_stmt->bind_param("id", $userid, $promille);
    $insert_stmt->execute();
    $insert_stmt->close();
}

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
    <link rel="stylesheet" href="style.css"> <!-- Lägg till din CSS-fil här -->
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
                <li><a href="loggaut.php">Logga ut</a></li>
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