<?php
function calculatePromille($userid, $conn) {
    // 1. Hämta användarens vikt
    $weight = 0; // tillfälligt default
    $stmt = $conn->prepare("SELECT weight FROM tbluser WHERE id = ?");
    $stmt->bind_param("i", $userid);
    $stmt->execute();
    $stmt->bind_result($weight);
    $stmt->fetch();
    $stmt->close();

    if (!$weight) return 0;

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

        // Alkohol i gram = volym × (procent / 100) × 0.789
        $grams = $volume * ($alc_percent / 100) * 0.789;
        $total_alcohol_grams += $grams;
    }

    $stmt->close();

    if ($total_alcohol_grams == 0) return 0;

    // 3. Räkna ut antal timmar sedan första dryck
    $hours = (time() - $earliest_time) / 3600;

    // 4. Beräkna promille
    $r = 0.68; // förenklad konstant
    $burn_rate_per_minute = (0.15* 100 ) / 60; // = 0.0025 promille per minut
    $minutes = (time() - $earliest_time) / 60;
    
    $burned = $burn_rate_per_minute * $minutes;
    
    $promille = ($total_alcohol_grams / ($weight * $r)) - $burned;
    $promille = max(0, $promille); // Förhindra negativa värden
    

    return $promille;
}
?>
