<?php
require_once 'func.php'; // Inkluderar funktioner som startar session och hanterar databasanslutning
require_once 'calculate_promille.php'; // Funktion för att räkna ut promille baserat på drycker

session_start(); // Startar sessionen om inte redan igång
if (!isset($_SESSION['userid'])) {
    // Om användaren inte är inloggad, skicka till inloggningssidan
    header("Location: loggain.php");
    exit;
}

$conn = getDBConnection(); // Etablerar databasanslutning
$userid = $_SESSION['userid']; // Hämtar användarens ID från sessionen
$drinktimestamp = $_POST['drinktimestamp'] ?? null; // Hämtar dryckens tidsstämpel från formuläret

if ($drinktimestamp) {
    // === 1. Ta bort drycken från databasen ===
    $stmt = $conn->prepare("DELETE FROM tbldrinklog WHERE userid = ? AND drinktimestamp = ?");
    $stmt->bind_param("is", $userid, $drinktimestamp); // Binder användar-ID och tidsstämpel
    $stmt->execute(); // Utför borttagningen
    $stmt->close();

    // === 2. Räkna om promille efter att drycken tagits bort ===
    $promille = calculatePromille($userid, $conn);

    // === 3. Kontrollera om det redan finns en promillepost för användaren ===
    $check_sql = "SELECT userid FROM tblpromille WHERE userid = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("i", $userid);
    $check_stmt->execute();
    $check_stmt->store_result(); // Behövs för att kunna kolla antal rader

    if ($check_stmt->num_rows > 0) {
        // === 4. Uppdatera existerande promillepost ===
        $update_sql = "UPDATE tblpromille SET promille = ?, updated_at = NOW() WHERE userid = ?";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("di", $promille, $userid);
        $update_stmt->execute();
        $update_stmt->close();
    } else {
        // === 5. Lägg till ny post om det inte fanns någon innan ===
        $insert_sql = "INSERT INTO tblpromille (userid, promille, updated_at) VALUES (?, ?, NOW())";
        $insert_stmt = $conn->prepare($insert_sql);
        $insert_stmt->bind_param("id", $userid, $promille);
        $insert_stmt->execute();
        $insert_stmt->close();
    }

    $check_stmt->close(); // Stänger statement för kontrollfrågan
}

$conn->close(); // Stänger databasen

// === 6. Skicka tillbaka användaren till sidan som visar drycker ===
header("Location: view_drinks.php");
exit;
?>
