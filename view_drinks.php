<?php
require_once 'func.php'; // Startar session och skapar databasanslutning

// Kontrollera inloggning
if (!isset($_SESSION['userid'])) {
    header("Location: loggain.php");
    exit;
}

$conn = getDBConnection();

// Om ett userid skickas i URL:en använder vi det, annars användarens egna
$userid_to_view = isset($_GET['userid']) ? (int)$_GET['userid'] : $_SESSION['userid'];

// Hämta användarens namn för rubriken
$name_sql = "SELECT namn FROM tbluser WHERE id = ?";
$name_stmt = $conn->prepare($name_sql);
$name_stmt->bind_param("i", $userid_to_view);
$name_stmt->execute();
$name_result = $name_stmt->get_result();
$user_name = ($name_result->num_rows > 0) ? $name_result->fetch_assoc()['namn'] : "Okänd";
$name_stmt->close();

// Hämta dryckeslogg
$sql = "SELECT drinktype, alcoholpercent, volume_ml, drinktimestamp 
        FROM tbldrinklog 
        WHERE userid = ? 
        ORDER BY drinktimestamp DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userid_to_view);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="sv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visa drycker</title>
    <link rel="stylesheet" href="style.css">
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
        <div class="view-drinks">
            <h2>Dryckeslogg för användare: <strong><?php echo htmlspecialchars($user_name); ?></strong></h2>

            <?php if ($result->num_rows > 0): ?>
                <table border="1">
                    <thead>
                        <tr>
                            <th>Dryckestyp</th>
                            <th>Alkohol%</th>
                            <th>Volym (ml)</th>
                            <th>Tid</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['drinktype']); ?></td>
                                <td><?php echo htmlspecialchars($row['alcoholpercent']); ?></td>
                                <td><?php echo htmlspecialchars($row['volume_ml']); ?></td>
                                <td><?php echo htmlspecialchars($row['drinktimestamp']); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>Inga drycker hittades för denna användare.</p>
            <?php endif; ?>

            <?php
            $stmt->close();
            $conn->close();
            ?>
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
