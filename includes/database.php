<?php
$host = "bit608-server.mysql.database.azure.com";
$username = "haffxpeibm";
$password = "H15N8Z0FFM4CUY6M$";
$ca_certificate = "/ssl.pem";
$database = "motueka";
$port = 3306;

// Create connection
try {
    $conn = mysqli_init();
    mysqli_ssl_set($conn, NULL, NULL, __DIR__ . $ca_certificate, NULL, NULL);
    mysqli_real_connect($conn, $servername, $username, $password, $database, $port, MYSQLI_CLIENT_SSL);
} catch (Exception $e) {
    echo "Service unavailable \n";
    exit;
}
if (!isset($_SESSION['alertList']["Database Connected Successfully"])) {
    $_SESSION['alertList']["Database Connected Successfully"] = array("type" => "success", "viewed" => 0);
}