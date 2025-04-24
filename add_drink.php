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
    <title>Lägg till dryck</title>
</head>
<body>
    <h2>Lägg till en dryck</h2>
    <form action="add_drink_submit.php" method="POST">
        Dryckestyp: <input type="text" name="drinktype" required><br>
        Alkoholhalt (%): <input type="number" name="alcoholpercent" step="0.1" required><br>
        Volym (ml): <input type="number" name="volume_ml" step="0.1" required><br>
        <input type="submit" value="Spara dryck">
    </form>
    <br>
    <a href="view_drinks.php">Visa mina tidigare drycker</a> |
    <a href="logout.php">Logga ut</a>
</body>
</html>
