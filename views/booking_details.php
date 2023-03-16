<?php
global $user;
global $conn;
$booking = $conn->query("SELECT * FROM booking WHERE bookingID = ".$bookingID);
if ($booking) {
    $booking = $booking->fetch_assoc();
    if($booking['customer'] == $user->getUserID() || $user->getUserType == "Admin"){
        var_dump($booking);
    } else {
        //go to login
        $_SESSION['alertList']["Booking belongs to different customer"] = array("type" => "danger", "viewed" => 0);
    }
} else {
    var_dump($conn->error);
}