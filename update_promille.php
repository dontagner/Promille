<?php
require_once 'func.php'; // Startar session och hämtar getDBConnection()

$conn = getDBConnection();

include_once 'calculate_promille.php';

// Hämta alla användare
$sql = "SELECT id FROM tbluser";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $userid = $row['id'];
        error_log("Uppdaterar promille för användare: $userid");

        // Beräkna promille
        $promille = calculatePromille($userid, $conn);

        if ($promille === null) {
            error_log("Promille kunde inte beräknas för användare: $userid");
            continue;
        }

        error_log("Beräknad promille för användare $userid: $promille");

        // Uppdatera eller lägg till användaren i tblpromille
        $stmt = $conn->prepare("
            INSERT INTO tblpromille (userid, promille, updated_at) 
            VALUES (?, ?, NOW()) 
            ON DUPLICATE KEY UPDATE promille = VALUES(promille), updated_at = NOW()
        ");
        if (!$stmt) {
            error_log("Fel vid förberedelse av SQL: " . $conn->error);
            continue;
        }

        $stmt->bind_param("id", $userid, $promille);

        if (!$stmt->execute()) {
            error_log("Fel vid uppdatering av promille: " . $stmt->error);
        } else {
            error_log("Promille uppdaterad för användare $userid.");
        }

        $stmt->close();

        $stmt_log = $conn->prepare("INSERT INTO tblpromillelog (userid, promille, updated_at) VALUES (?, ?, NOW())");
        $stmt_log->bind_param("id", $userid, $promille);
        $stmt_log->execute();
        $stmt_log->close();


        // ...efter att alla användares promille har uppdaterats...

        $teams = ['Ayia Napa', 'Magaluf'];
        foreach ($teams as $team) {
            // Hämta snittpromille för laget just nu
            $sql = "SELECT AVG(p.promille) AS avg_promille
                    FROM tbluser u
                    JOIN tblpromille p ON u.id = p.userid
                    WHERE u.team = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $team);
            $stmt->execute();
            $stmt->bind_result($avg_promille);
            $stmt->fetch();
            $stmt->close();

            // Spara i loggen
            $sql_log = "INSERT INTO team_avg_log (team, avg_promille, log_time) VALUES (?, ?, NOW())";
            $stmt_log = $conn->prepare($sql_log);
            $stmt_log->bind_param("sd", $team, $avg_promille);
            $stmt_log->execute();
            $stmt_log->close();
}

    }
} else {
    error_log("Inga användare hittades.");
}

$conn->close();

echo "Promille uppdaterad.";
?>
