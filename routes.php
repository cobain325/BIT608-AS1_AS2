<?php

require_once __DIR__ . '/router.php';

post('/booking/created', function () {
    $_POST = json_decode(file_get_contents("php://input"), true);
    global $conn;
    if (!$conn->query("INSERT INTO `booking`(`room`, `checkIn`, `checkOut`, `customer`, `contactNumber`, `extras`) VALUES ('" . $_POST['room'] . "','" . $_POST['checkInDate'] . "','" . $_POST['checkoutDate'] . "','" . $_POST['user'] . "','" . $_POST['contactNumber'] . "','" . $_POST['extras'] . "')")) {
        die(json_encode($conn->error));
    } else {
        $_SESSION['alertList']["Booking Created Successfully"] = array("type" => "success", "viewed" => 0);
        die(json_encode(array('message' => 'success', 'booking' => mysqli_insert_id($conn))));
    }
});

get('/', function () {
    include "views/home.php";
});
get('/privacy', function () {
    include "views/privacy.php";
});
get('/bookings', function () {
    include "views/bookings.php";
});
get('/bookings/create', function () {
    include "views/booking_create.php";
});
get('/bookings/$bookingID', function ($bookingID) {
    include "views/booking_details.php";
});
get('/bookings/$bookingID/edit', function ($bookingID) {
    include "views/booking_details.php";
});
get('/bookings/$bookingID/delete', function ($bookingID) {
    include "views/booking_details.php";
});
get('/rooms', function () {
    include "views/rooms.php";
});

any('/404', "views/404.php");