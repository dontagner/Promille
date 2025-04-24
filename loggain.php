<!DOCTYPE html>
<html lang="sv">
<head>
    <meta charset="UTF-8">
    <title>Logga in</title>
</head>
<body>
    <h2>Logga in</h2>
    <form action="loggain_submit.php" method="POST">
        Namn: <input type="text" name="namn" required><br>
        Lösenord: <input type="password" name="password" required><br>
        <input type="submit" value="Logga in">
    </form>
</body>
</html>
