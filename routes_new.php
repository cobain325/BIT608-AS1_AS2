<?php
//All routes for website are defined here.

//$getRequests contains all the GET requests.
//$postRequests contains all the POST requests.

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
            $checkInDate_formatted = date('Y-m-d H:i:s', $checkInDate);
            $checkoutDate = strtotime($_POST['checkoutDate'] . " 10:00:00");
            $checkoutDate_formatted = date('Y-m-d H:i:s', $checkoutDate);

            $query = "INSERT INTO `booking`(`room`, `checkIn`, `checkOut`, `customer`, `contactNumber`, `extras`) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ssssss", $_POST['room'], $checkInDate_formatted, $checkoutDate_formatted, $_POST['user'], $_POST['contactNumber'], $_POST['extras']);
            if (!$stmt->execute()) {
                die(json_encode(array('message' => 'error', 'error' => "Database Error")));
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
            $checkInDate_formatted = date('Y-m-d H:i:s', $checkInDate);
            $checkoutDate = strtotime($_POST['checkoutDate'] . " 10:00:00");
            $checkoutDate_formatted = date('Y-m-d H:i:s', $checkoutDate);

            $stmt = $conn->prepare("UPDATE `booking` SET `room`=?, `checkIn`=?, `checkOut`=?, `customer`=?, `contactNumber`=?, `extras`=?, `review`=? WHERE `bookingID` = ?");
            if (!$stmt) {
                die(json_encode(array('message' => 'error', 'error' => "Database Error")));
            }

            $stmt->bind_param(
                "sssssssi",
                $_POST['room'],
                $checkInDate_formatted,
                $checkoutDate_formatted,
                $_POST['user'],
                $_POST['contactNumber'],
                $_POST['extras'],
                $_POST['review'],
                $_POST['bookingID']
            );

            if (!$stmt->execute()) {
                die(json_encode(array('message' => 'error', 'error' => "Database Error")));
            }

            $_SESSION['alertList']["Booking Updated Successfully"] = array("type" => "success", "viewed" => 0);
            die(json_encode(array('message' => 'success', 'booking' => $_POST['bookingID'])));
        }
    ),
    '/booking/delete' => array(
        'name' => 'Booking Delete',
        'function' => function () {
            $_POST = json_decode(file_get_contents("php://input"), true);
            global $conn;
            $query = "DELETE FROM `booking` WHERE `bookingID` = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("i", $_POST['bookingID']);
            if (!$stmt->execute()) {
                die(json_encode(array('message' => 'error', 'error' => "Database Error")));
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
            $checkInDate_formatted = date('Y-m-d H:i:s', $checkInDate);
            $checkoutDate = strtotime($_POST['checkoutDate'] . " 10:00:00");
            $checkoutDate_formatted = date('Y-m-d H:i:s', $checkoutDate);

            $editing = false;
            $bookingID = '';

            if (array_key_exists('bookingID', $_POST)) {
                global $editing;
                $editing = true;
                $bookingID = $_POST['bookingID'];
            }

            $query = "SELECT *
                      FROM room
                      WHERE roomID NOT IN (
                          SELECT room
                          FROM booking
                          WHERE (checkIn >= ? AND checkOut <= ?)
                          OR (checkIn < ? AND checkOut > ?)
                      ) ";

            $parameters = array($checkInDate_formatted, $checkoutDate_formatted, $checkoutDate_formatted, $checkInDate_formatted);
            $typeDefinition = 'ssss';
            if ($editing) {
                $query .= " OR roomID IN (
                                SELECT room
                                FROM booking
                                WHERE bookingID = ?
                            )";
                $parameters[] = $bookingID;
                $typeDefinition .= 'i';
            }

            $stmt = $conn->prepare($query);

            if (!$stmt) {
                die(json_encode(array('message' => 'error', 'error' => "Database Error")));
            }

            $stmt->bind_param($typeDefinition, ...$parameters);
            $stmt->execute();
            $result = $stmt->get_result();

            if (!$result) {
                die(json_encode(array('message' => 'error', 'error' => "Database Error")));
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
            if ($user->getUserStatus() == null) {
                $_SESSION['alertList']["Successfully logged in."] = array("type" => "success", "viewed" => 0);
                die(json_encode(array('message' => 'success', 'user' => $user->getCustomerName(), 'token' => $user->getUserToken())));
            } else {
                die(json_encode(array('message' => 'error', 'user' => $user->getUserStatus())));
            }
        }
    ),
);
include 'router_new.php';
?>