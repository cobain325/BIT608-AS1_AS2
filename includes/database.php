<?php
$servername = "bit608-server.mysql.database.azure.com";
$username = "haffxpeibm";
$password = "H15N8Z0FFM4CUY6M";

$conn = mysqli_init();
mysqli_ssl_set($conn, NULL, NULL, "/ssl.pem", NULL, NULL);

// Create connection
try {
    mysqli_real_connect($conn, $servername, $username, $password, 'motueka', 3306, MYSQLI_CLIENT_SSL);
} catch (Exception $e) {
    echo "Service unavailable";
    print($e);
    exit;
}
if (!isset($_SESSION['alertList']["Database Connected Successfully"])) {
    $_SESSION['alertList']["Database Connected Successfully"] = array("type" => "success", "viewed" => 0);
}