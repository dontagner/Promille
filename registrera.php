<!DOCTYPE html>
<html lang="sv">
<head>
    <meta charset="UTF-8">
    <title>Registrera dig</title>
</head>
<body>
    <h2>Registrera dig</h2>
    <form action="registrera_submit.php" method="POST">
        Namn: <input type="text" name="namn" required><br>
        Lösenord: <input type="password" name="password" required><br>
        Vikt (kg): <input type="number" step="0.1" name="weight" required><br>
        Längd (cm): <input type="number" step="0.1" name="height" required><br>
        <input type="submit" value="Registrera">
    </form>
</body>
</html>
