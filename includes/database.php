<?php
$servername = "bit608-server.mysql.database.azure.com";
$username = "haffxpeibm";
$password = "H15N8Z0FFM4CUY6M";

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
