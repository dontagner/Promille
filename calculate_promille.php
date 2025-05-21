<?php
// Sätter tidszon till UTC för att hantera tid korrekt
date_default_timezone_set('UTC');

/**
 * Beräknar promillehalt för en viss användare baserat på drycker de senaste 6 timmarna
 * 
 * @param int $userid Användarens ID
 * @param mysqli $conn Databasanslutning
 * @return float Beräknad promillehalt
 */
function calculatePromille($userid, $conn) {
    // Logg för felsökning
    error_log("Beräknar promille för användare: $userid");

    // 1. Hämta användarens vikt från databasen
    $weight = 0;
    $stmt = $conn->prepare("SELECT weight FROM tbluser WHERE id = ?");
    $stmt->bind_param("i", $userid);
    $stmt->execute();
    $stmt->bind_result($weight);
    $stmt->fetch();
    $stmt->close();

    // Om ingen vikt är satt, returnera 0 som promille
    if (!$weight) {
        error_log("Ingen vikt hittades för användare: $userid");
        return 0;
    }

    // 2. Hämta alla drycker som druckits de senaste 6 timmarna
    $sql = "SELECT alcoholpercent, volume_ml, drinktimestamp
            FROM tbldrinklog 
            WHERE userid = ? AND drinktimestamp >= UTC_TIMESTAMP() - INTERVAL 6 HOUR";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userid);
    $stmt->execute();
    $result = $stmt->get_result();

    $total_alcohol_grams = 0; // Total mängd alkohol i gram
    $earliest_time = null;    // Tidpunkt för första drycken inom perioden

    // 3. Summera alkoholmängden i gram och hitta tidigaste drycken
    while ($row = $result->fetch_assoc()) {
        $alc_percent = $row['alcoholpercent']; // Alkoholhalt i procent
        $volume = $row['volume_ml'];           // Volym i milliliter
        $time = strtotime($row['drinktimestamp']); // Tidpunkt för drycken som UNIX-tid

        // Håll reda på den tidigaste drycken
        if (!$earliest_time || $time < $earliest_time) {
            $earliest_time = $time;
        }

        // Omvandla volym och alkoholhalt till gram alkohol
        // Densitet för etanol = 0.789 g/ml
        $grams = $volume * ($alc_percent / 100) * 0.789;
        $total_alcohol_grams += $grams;
    }

    $stmt->close();

    // Om inga drycker hittats returneras promille 0
    if (!$earliest_time) {
        error_log("Ingen dryck hittades inom de senaste 6 timmarna för användare: $userid");
        return 0;
    }

    if ($total_alcohol_grams == 0) {
        error_log("Ingen alkohol hittades för användare: $userid");
        return 0;
    }

    // 4. Beräkna hur lång tid som passerat sedan första drycken
    $current_time = time();
    $minutes_since_first_drink = max(0, ($current_time - $earliest_time) / 60); // i minuter

    // 5. Beräkna alkoholpromille enligt Widmarks formel
    $r = 0.68; // Vattendelning – används ofta för män (kvinnor har t.ex. ~0.55)
    $burn_rate_per_minute = 0.15 / 60; // Alkohol som förbränns per minut (0.15 promille/timme)
    $burned = $burn_rate_per_minute * $minutes_since_first_drink;

    // Grundformel: (gram alkohol / (kroppsvikt * r)) - förbränt
    $promille = ($total_alcohol_grams / ($weight * $r)) - $burned;

    // Säkerställ att promillen inte blir negativ
    $promille = max(0, $promille);

    // Logg för felsökning
    error_log("Användare: $userid, Total alkohol i gram: $total_alcohol_grams, Tid sedan första dryck: $minutes_since_first_drink minuter, Förbränd alkohol: $burned, Beräknad promille: $promille");

    return $promille;
}
?>