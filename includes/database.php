<?php
$servername = "127.0.0.1";
$username = "root";
$password = "root";

// Create connection
try {
    $conn = new mysqli($servername, $username, $password, 'motueka');
} catch (Exception $e ) {
    echo "Service unavailable";
    exit;
}
if(!isset($_SESSION['alertList']["Database Connected Successfully"])){
    $_SESSION['alertList']["Database Connected Successfully"] = array("type" => "success", "viewed" => 0);
} 
