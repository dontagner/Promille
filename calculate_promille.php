<?php
date_default_timezone_set('Europe/Stockholm');
function calculatePromille($userid, $conn) {
    error_log("Beräknar promille för användare: $userid");

    // 1. Hämta användarens vikt
    $weight = 0;
    $stmt = $conn->prepare("SELECT weight FROM tbluser WHERE id = ?");
    $stmt->bind_param("i", $userid);
    $stmt->execute();
    $stmt->bind_result($weight);
    $stmt->fetch();
    $stmt->close();

    if (!$weight) {
        error_log("Ingen vikt hittades för användare: $userid");
        return 0;
    }

    // 2. Hämta alla drycker de senaste 6 timmarna
    $sql = "SELECT alcoholpercent, volume_ml, drinktimestamp
            FROM tbldrinklog 
            WHERE userid = ? AND drinktimestamp >= NOW() - INTERVAL 6 HOUR";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userid);
    $stmt->execute();
    $result = $stmt->get_result();

    $total_alcohol_grams = 0;
    $earliest_time = null;

    while ($row = $result->fetch_assoc()) {
        $alc_percent = $row['alcoholpercent'];
        $volume = $row['volume_ml'];
        $time = strtotime($row['drinktimestamp']);

        if (!$earliest_time || $time < $earliest_time) {
            $earliest_time = $time;
        }

        $grams = $volume * ($alc_percent / 100) * 0.789;
        $total_alcohol_grams += $grams;
    }

    $stmt->close();

    if (!$earliest_time) {
        error_log("Ingen dryck hittades inom de senaste 6 timmarna för användare: $userid");
        return 0;
    }

    if ($total_alcohol_grams == 0) {
        error_log("Ingen alkohol hittades för användare: $userid");
        return 0;
    }

    $current_time = time();
    $minutes_since_first_drink = max(0, ($current_time - $earliest_time) / 60);

    $r = 0.68;
    $burn_rate_per_minute = (0.15) / 60;
    $burned = $burn_rate_per_minute * $minutes_since_first_drink;

    $promille = ($total_alcohol_grams / ($weight * $r)) - $burned;
    $promille = max(0, $promille);

    error_log("Användare: $userid, Total alkohol i gram: $total_alcohol_grams, Tid sedan första dryck: $minutes_since_first_drink minuter, Förbränd alkohol: $burned, Beräknad promille: $promille");

    return $promille;
}
?>