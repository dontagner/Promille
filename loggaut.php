<?php
session_start(); // Starta sessionen

// Rensa alla sessionvariabler
session_unset(); 

// Avsluta sessionen
session_destroy(); 

// Om du vill omdirigera användaren till en annan sida efter utloggning
header("Location: loggain.php"); 
exit();
?>
