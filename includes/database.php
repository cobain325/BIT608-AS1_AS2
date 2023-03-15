<?php
$servername = "127.0.0.1";
$username = "root";
$password = "root";

// Create connection
$conn = new mysqli($servername, $username, $password, 'motueka');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$_SESSION['alertList']["Database Connected Successfully"] = array("type" => "success", "viewed" => 0);
