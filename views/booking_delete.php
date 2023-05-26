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
`booking`.`bookingID` =  " . $bookingID);
?>
<div class="card-body">
    <?php
    if ($booking) {
        if ($booking->num_rows > 0) {
            $booking = $booking->fetch_assoc();
            if ($booking['customer'] == $user->getUserID() || $user->getUserType() == "Admin") {
                ?>
                <ul class="list-group">
                    <li class="list-group-item"><strong>Room: </strong>
                        <?php echo $booking['roomname'] ?>
                    </li>
                    <li class="list-group-item"><strong>Check In Date: </strong>
                        <?php echo date("d/m/Y", strtotime($booking['checkIn'])) ?>
                    </li>
                    <li class="list-group-item"><strong>Check Out Date: </strong>
                        <?php echo date("d/m/Y", strtotime($booking['checkOut'])) ?>
                    </li>
                    <li class="list-group-item"><strong>Contact Number: </strong><a
                            href="tel:<?php echo $booking['contactNumber'] ?>"><?php echo $booking['contactNumber'] ?></a></li>
                    <li class="list-group-item"><strong>Extras: </strong>
                        <?php echo $booking['extras'] ?>
                    </li>
                    <li class="list-group-item"><strong>Review: </strong>
                        <?php echo $booking['review'] ?>
                    </li>
                </ul>
                <h6>Are you sure you want to delete this booking?</h6>
                <div>
                    <button type="button" class="btn btn-outline-secondary" id="cancelButton">Cancel</button>
                    <button type="button" class="btn btn-outline-danger" id="deleteButton">Delete</button>
                </div>
                <?php
            } else {
                ?>
                <div class="alert alert-danger" role="alert">
                    Please login first.
                </div>
                <script>
                    loginModal.show();</script>
                <?php
            }
        } else {
            ?>
            <div class="alert alert-danger" role="alert">
                Booking not found.
            </div>
            <?php
        }
    } else {
        ?>
        <div class="alert alert-danger" role="alert">
            Database Error.
        </div>
        <?php
    }
    ?>
</div>
<script>
    const deleteButton = document.getElementById("deleteButton")
    const cancelButton = document.getElementById("cancelButton")

    cancelButton.addEventListener("click", () => {

        location.href = "/bookings/" + <?php echo $booking['bookingID'] ?>;
    })
    deleteButton.addEventListener("click", async () => {
        const response = await fetch('/booking/delete', {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ <?php echo "bookingID: " . $booking['bookingID'] ?> })
        });
        const content = await response.json();
        if (content.message == "success") {
            location.href = "/bookings"
        } else {
            //add error handling.
            console.log(content)
        }
    })
</script>