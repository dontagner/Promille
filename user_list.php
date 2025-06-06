<?php
require_once 'func.php'; // Startar session och ger tillgång till getDBConnection()

// Kontrollera inloggning
if (!isset($_SESSION['userid'])) {
    header("Location: loggain.php");
    exit;
}

$conn = getDBConnection();

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
    <link rel="stylesheet" href="style.css">
    <link rel="icon" type="image/x-icon" href="bilder/favicon/favicon.ico">
<link rel="icon" type="image/png" sizes="32x32" href="bilder/favicon/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="bilder/favicon/favicon-16x16.png">
<link rel="apple-touch-icon" sizes="180x180" href="bilder/favicon/apple-touch-icon.png">
<link rel="manifest" href="bilder/favicon/site.webmanifest">
    <script>
        function toggleDropdown() {
            const dropdown = document.querySelector(".dropdown");
            dropdown.classList.toggle("show");
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
        <div class="user-list">
            <h2>Lista över användare och deras promille</h2>

            <?php if ($result && $result->num_rows > 0): ?>
                <ul>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <?php
                        $user_id = $row['id'];
                        $namn = htmlspecialchars($row['namn']);
                        $promille = is_null($row['promille']) ? "–" : number_format($row['promille'], 2) . " ‰";
                        ?>
                        <li>
                            <a href="view_drinks.php?userid=<?php echo $user_id; ?>">
                                <?php echo $namn; ?> (<?php echo $promille; ?>)
                            </a>
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
