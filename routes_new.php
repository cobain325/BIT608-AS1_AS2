<?php
$getRequests = array(
    '/' => array(
        'name' => 'Home',
        'function' => function () {
            include 'views/home.php';
        }
    ),
    '/bookings' => array(
        'name' => 'Bookings',
        'function' => function ($routeParams) {
            include 'views/bookings.php';
        }
    ),
    '/bookings/create' => array(
        'name' => 'Create Booking',
        'function' => function ($routeParams) {
            include 'views/booking_create.php';
        }
    ),
    '/bookings/$bookingID' => array(
        'name' => 'Booking Details',
        'function' => function ($routeParams) {
            include 'views/booking_details.php';
        }
    ),
    '/bookings/$bookingID/edit' => array(
        'name' => 'Edit Booking',
        'function' => function ($routeParams) {
            include 'views/booking_edit.php';
        }
    ),
    '/bookings/$bookingID/delete' => array(
        'name' => 'Delete Booking',
        'function' => function ($routeParams) {
            include 'views/booking_delete.php';
        }
    ),
    '/rooms' => array(
        'name' => 'Rooms',
        'function' => function ($routeParams) {
            include 'views/rooms.php';
        }
    ),
    '/privacy' => array(
        'name' => 'Privacy Policy',
        'function' => function ($routeParams) {
            include 'views/privacy.php';
        }
    )
);
$postRequests = array(
    '/logout' => array(
        'name' => 'Logout',
        'function' => function () {
            require_once 'includes/user.php';
            if (isset($_SESSION['user'])) {
                unset($_SESSION['user']);
            }
            global $user;
            $user = new User();
            die(json_encode(array('message' => 'success')));
        }
    ),
    '/booking/created' => array(
        'name' => 'Booking Create',
        'function' => function () {
            $_POST = json_decode(file_get_contents("php://input"), true);
            global $conn;
            $checkInDate = strtotime($_POST['checkInDate'] . " 14:00:00");
            $checkInDate_formated = date('Y-m-d H:i:s', $checkInDate);
            $checkoutDate = strtotime($_POST['checkoutDate'] . " 10:00:00");
            $checkoutDate_formated = date('Y-m-d H:i:s', $checkoutDate);
            if (!$conn->query("INSERT INTO `booking`(`room`, `checkIn`, `checkOut`, `customer`, `contactNumber`, `extras`) VALUES ('" . $_POST['room'] . "','" . $checkInDate_formated . "','" . $checkoutDate_formated . "','" . $_POST['user'] . "','" . $_POST['contactNumber'] . "','" . $_POST['extras'] . "')")) {
                die(json_encode($conn->error));
            } else {
                $_SESSION['alertList']["Booking Created Successfully"] = array("type" => "success", "viewed" => 0);
                die(json_encode(array('message' => 'success', 'booking' => mysqli_insert_id($conn))));
            }
        }
    ),
    '/booking/edit' => array(
        'name' => 'Booking Edit',
        'function' => function () {
            $_POST = json_decode(file_get_contents("php://input"), true);
            global $conn;
            $checkInDate = strtotime($_POST['checkInDate'] . " 14:00:00");
            $checkInDate_formated = date('Y-m-d H:i:s', $checkInDate);
            $checkoutDate = strtotime($_POST['checkoutDate'] . " 10:00:00");
            $checkoutDate_formated = date('Y-m-d H:i:s', $checkoutDate);
            if (!$conn->query("UPDATE `booking` SET `room`='" . $_POST['room'] . "', `checkIn`='" . $checkInDate_formated . "',`checkOut`='" . $checkoutDate_formated . "',`customer`='" . $_POST['user'] . "', `contactNumber`='" . $_POST['contactNumber'] . "',`extras`='" . $_POST['extras'] . "',`review`='" . $_POST['review'] . "' WHERE `bookingID` = '" . $_POST['bookingID'] . "'")) {
                die(json_encode($conn->error));
            } else {
                $_SESSION['alertList']["Booking Updated Successfully"] = array("type" => "success", "viewed" => 0);
                die(json_encode(array('message' => 'success', 'booking' => $_POST['bookingID'])));
            }
        }
    ),
    '/booking/delete' => array(
        'name' => 'Booking Delete',
        'function' => function () {
            $_POST = json_decode(file_get_contents("php://input"), true);
            global $conn;
            if (!$conn->query("DELETE FROM `booking` WHERE `bookingID` = " . $_POST['bookingID'])) {
                die(json_encode($conn->error));
            } else {
                $_SESSION['alertList']["Booking Deleted Successfully"] = array("type" => "success", "viewed" => 0);
                die(json_encode(array('message' => 'success', 'booking' => $_POST['bookingID'])));
            }
        }
    ),
    '/booking/check' => array(
        'name' => 'Booking Check Availability',
        'function' => function () {
            $_POST = json_decode(file_get_contents("php://input"), true);
            global $conn;
            $checkInDate = strtotime($_POST['checkInDate'] . " 14:00:00");
            $checkInDate_formated = date('Y-m-d H:i:s', $checkInDate);
            $checkoutDate = strtotime($_POST['checkoutDate'] . " 10:00:00");
            $checkoutDate_formated = date('Y-m-d H:i:s', $checkoutDate);
            $bookingID = $_POST['bookingID'];
            $result = $conn->query("SELECT * FROM room WHERE roomID NOT IN (SELECT room FROM booking WHERE checkIn >= '" . $checkInDate_formated . "' AND checkOut <= '" . $checkoutDate_formated . "') AND bookingID != '" . $bookingID . "'");

            if (
                !$result
            ) {
                die(json_encode($conn->error));
            } else {
                die(json_encode(array('message' => 'success', 'result' => $result->fetch_all())));
            }
        }
    ),
    '/login' => array(
        'name' => 'Login',
        'function' => function () {
            require_once 'includes/user.php';
            $_POST = json_decode(file_get_contents("php://input"), true);
            $email = $_POST['email'];
            $password = $_POST['password'];
            $user = new User($email, $password);
            if ($user->getUserType() != null) {
                die(json_encode(array('message' => 'success', 'user' => $user)));
            } else {
                die(json_encode(array('message' => 'fail', 'user' => $user)));
            }
        }
    ),
);
include 'router_new.php';
?>