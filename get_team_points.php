<?php
require_once 'func.php';
$conn = getDBConnection();

$sql = "SELECT team, points FROM team_points ORDER BY points DESC";
$result = $conn->query($sql);

while ($row = $result->fetch_assoc()) {
    echo "<tr><td>{$row['team']}</td><td>{$row['points']}</td></tr>";
}
$conn->close();
?>