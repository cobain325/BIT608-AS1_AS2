<?php
global $user;
global $conn;
$bookingID = $routeParams['bookingID'];
$booking = $conn->query("SELECT
`booking`.`bookingID`,`booking`.`room`,`booking`.`checkIn`,`booking`.`checkOut`,`booking`.`customer`,`booking`.`contactNumber`,`booking`.`extras`,`booking`.`review`,`customer`.`customerID`,`customer`.`firstname`,`customer`.`lastname`,`customer`.`email`,`room`.`roomID`,`room`.`roomname`,`room`.`description`,`room`.`roomtype`,`room`.`beds`
FROM
`booking`
LEFT JOIN `room` ON `booking`.`room` = `room`.`roomID`
LEFT JOIN `customer` ON `booking`.`customer` = `customer`.`customerID`
WHERE
`booking`.`bookingID` =  ". $bookingID);
if ($booking) {
    if ($booking->num_rows > 0) {
        $booking = $booking->fetch_assoc();
        if ($booking['customer'] == $user->getUserID() || $user->getUserType() == "Admin") {
            include "views/booking_create.php";
        } else {
            echo "<div class=\"alert alert-danger\" role=\"alert\">
        Please login first.
    </div><script>
        loginModal.show();</script>";
        }
    } else {
        echo "<div class=\"alert alert-danger\" role=\"alert\">
        Booking not found.
        </div>";
    }
} else {
    echo "<div class=\"alert alert-danger\" role=\"alert\">
        Database Error.
        </div>";
}
?>
