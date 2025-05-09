<?php
session_start();
if (!isset($_SESSION['userid'])) {
    header("Location: loggain.php");
    exit;
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "promille";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Kunde inte ansluta: " . $conn->connect_error);
}

// Hämta alla användare
$sql = "SELECT u.id, u.namn, p.promille 
        FROM tbluser u 
        LEFT JOIN tblpromille p ON u.id = p.userid
        ORDER BY u.namn ASC";

$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="sv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Användarlista</title>
    <link rel="stylesheet" href="style.css"> <!-- Lägg till din CSS-fil här -->
</head>
<body>
    <!-- Header -->
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

    <!-- Main Content -->
    <main>
        <div class="user-list">
        <h2>Lista över användare och deras promille</h2>

        <?php if ($result->num_rows > 0): ?>
            <ul>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <?php
                    $user_id = $row['id'];
                    $namn = htmlspecialchars($row['namn']);
                    $promille = is_null($row['promille']) ? "–" : number_format($row['promille'], 2) . " ‰";
                    ?>
                    <li>
                        <a href="view_drinks.php?userid=<?php echo $user_id; ?>"><?php echo $namn; ?> (<?php echo $promille; ?>)</a>
                    </li>
                <?php endwhile; ?>
            </ul>
        <?php else: ?>
            <p>Inga användare hittades.</p>
        <?php endif; ?>

        <?php $conn->close(); ?>
        </div>
    </main>

    <!-- Footer -->
    <footer>
        <p>&copy; 2025 Promille Tracker</p>
    </footer>
</body>
</html>