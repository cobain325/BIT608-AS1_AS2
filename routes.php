<?php

require_once __DIR__ . '/router.php';

post('/logout', function () {
    require_once 'includes/user.php';
    if(isset($_SESSION['user'])) {
        unset($_SESSION['user']);
    }
    global $user;
    $user = new User();
    die(json_encode(array('message' => 'success')));
});

post('/booking/created', function () {
    $_POST = json_decode(file_get_contents("php://input"), true);
    global $conn;
    $checkInDate = strtotime($_POST['checkInDate']." 14:00:00");
    $checkInDate_formated = date('Y-m-d H:i:s', $checkInDate);
    $checkoutDate = strtotime($_POST['checkoutDate']." 10:00:00");
    $checkoutDate_formated = date('Y-m-d H:i:s', $checkoutDate);
    if (!$conn->query("INSERT INTO `booking`(`room`, `checkIn`, `checkOut`, `customer`, `contactNumber`, `extras`) VALUES ('" . $_POST['room'] . "','" . $checkInDate_formated . "','" . $checkoutDate_formated . "','" . $_POST['user'] . "','" . $_POST['contactNumber'] . "','" . $_POST['extras'] . "')")) {
        die(json_encode($conn->error));
    } else {
        $_SESSION['alertList']["Booking Created Successfully"] = array("type" => "success", "viewed" => 0);
        die(json_encode(array('message' => 'success', 'booking' => mysqli_insert_id($conn))));
    }
});

post('/booking/edit', function () {
    $_POST = json_decode(file_get_contents("php://input"), true);
    global $conn;
    $checkInDate = strtotime($_POST['checkInDate']." 14:00:00");
    $checkInDate_formated = date('Y-m-d H:i:s', $checkInDate);
    $checkoutDate = strtotime($_POST['checkoutDate']." 10:00:00");
    $checkoutDate_formated = date('Y-m-d H:i:s', $checkoutDate);
    if (!$conn->query("UPDATE `booking` SET `room`='" . $_POST['room'] . "', `checkIn`='". $checkInDate_formated ."',`checkOut`='". $checkoutDate_formated ."',`customer`='" . $_POST['user'] . "', `contactNumber`='" . $_POST['contactNumber'] . "',`extras`='" . $_POST['extras'] . "',`review`='" . $_POST['review'] . "' WHERE `bookingID` = '".$_POST['bookingID']."'")) {
        die(json_encode($conn->error));
    } else {
        $_SESSION['alertList']["Booking Created Successfully"] = array("type" => "success", "viewed" => 0);
        die(json_encode(array('message' => 'success', 'booking' => $_POST['bookingID'])));
    }
});

post('/login', function () {
    require_once 'includes/user.php';
    $_POST = json_decode(file_get_contents("php://input"), true);
    $email = $_POST['email'];
    $password = $_POST['password'];
    $user = new User($email, $password);
    if($user->getUserType() != null) {
        die(json_encode(array('message' =>  'success', 'user' => $user)));
    } else {
        die(json_encode(array('message' => 'fail', 'user' => $user)));
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
    include "views/booking_edit.php";
});
get('/bookings/$bookingID/delete', function ($bookingID) {
    include "views/booking_delete.php";
});
get('/rooms', function () {
    include "views/rooms.php";
});

any('/404', "views/404.php");