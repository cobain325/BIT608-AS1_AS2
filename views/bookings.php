<?php
global $conn;
global $user;
if($user->getUserType() == "Guest") {
    ?><div class="alert alert-danger" role="alert">
        Please login first.
    </div><script>
        loginModal.show();</script>
        <?php
} else {
if ($user->getUserType() == "Admin") {
    $bookings = $conn->query("SELECT * FROM booking");
} else {
    $bookings = $conn->query("SELECT * FROM booking WHERE customer = '" . $user->getUserID() . "'");
}
if($bookings->num_rows > 0){
?>
<div class="card-header">
    Existing bookings for
    <?php echo $user->getCustomerName() ?>
</div>
<ul class="list-group">
    <?php
    foreach ($bookings as $booking) {
        echo "
        <li class=\"list-group-item\" style=\"display: flex; justify-content: space-between;\">
            <div>
                <span>Booking #:" . $booking['bookingID'] . " | Check In: " . date("d/m/Y", strtotime($booking['checkIn'])) . " - Check Out: " . date("d/m/Y", strtotime($booking['checkOut'])) . "</span></div>
            <div>
                <a class=\"btn btn-outline-secondary\" href=\"/bookings/" . $booking['bookingID'] . "\" role=\"button\">View</a>
                <a class=\"btn btn-outline-info\" href=\"/bookings/" . $booking['bookingID'] . "/edit\" role=\"button\">Edit</a>
                <a class=\"btn btn-outline-danger\" href=\"/bookings/" . $booking['bookingID'] . "/delete\" role=\"button\">Delete</a>
            </div>
        </li>";
    }
    ?>
    </div>
    <?php
} else {
    echo "<div class=\"alert alert-warning\" role=\"alert\">
    No bookings found. Please create booking first.
</div>";
}
}
?>