<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "promille";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Kunde inte ansluta: " . $conn->connect_error);
}

// Hämta alla användare
$sql = "SELECT id FROM tbluser";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $userid = $row['id'];

        // Debug: Kontrollera användar-ID
        error_log("Uppdaterar promille för användare: $userid");

        // Beräkna promille för varje användare
        include 'calculate_promille.php';
        $promille = calculatePromille($userid, $conn);

        // Debug: Kontrollera beräknad promille
        error_log("Beräknad promille för användare $userid: $promille");

        // Uppdatera promillen i databasen
        $stmt = $conn->prepare("UPDATE tblpromille SET promille = ?, updated_at = NOW() WHERE userid = ?");
        if (!$stmt) {
            error_log("Fel vid förberedelse av SQL: " . $conn->error);
            continue;
        }
        $stmt->bind_param("di", $promille, $userid);
        if (!$stmt->execute()) {
            error_log("Fel vid uppdatering av promille: " . $stmt->error);
        }
        $stmt->close();
    }
} else {
    error_log("Inga användare hittades.");
}

$conn->close();
echo "Promille uppdaterad.";
?>