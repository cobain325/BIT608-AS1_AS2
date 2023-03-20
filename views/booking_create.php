<?php
global $conn;
global $route;
global $user;
function isEditing() {
    $route = rtrim($_SERVER['REQUEST_URI'], '/');
    $route = explode('/', $route);
    if(!empty( $route[3] ) && $route[3] == 'edit'){
        return true;
    } else {
        return false;
    }
}
$rooms = mysqli_query($conn, "SELECT * FROM room");
if (isEditing()) {
    echo "<h4>Edit Booking</h4>";
} else {
    echo "<h4>Create Booking</h4>";
}
?>
<h5>Booking for
    <?php 
    if (isEditing()) {
        echo $booking['firstname']. " " . $booking['lastname'];
    } else {
        echo $user->getCustomerName();
    }
    ?>
</h5>
<form class="needs-validation" id="createForm" novalidate>
    <div class="form-group">
        <label for="roomSelect">Room (name, type, beds)</label>
        <select class="form-control" id="roomSelect" required>
            <option selected disabled value="">Please select a room</option>
            <?php
            foreach ($rooms as $room) {
                echo "<option value=\"" . $room['roomID'] . "\">" . $room['roomname'] . ", " . $room['roomtype'] . ", " . $room['beds'] . "</option>";
            }
            ?>
        </select>
        <div class="invalid-feedback">
            Please choose a room.
        </div>
    </div>
    <div class="form-group">
        <label for="checkinDate">Checkin Date</label>
        <input class="form-control" id="checkinDate" required />
        <div class="invalid-feedback">
            Please choose a checkin date.
        </div>
    </div>
    <div class="form-group">
        <label for="checkoutDate">Checkout Date</label>
        <input class="form-control" id="checkoutDate" required />
        <div class="invalid-feedback">
            Please choose a checkout date.
        </div>
    </div>
    <div class="form-group">
        <label for="contactNumber">Contact Number</label>
        <input class="form-control" type="tel" id="contactNumber" required />
        <div class="invalid-feedback">
            Please enter a contact number.
        </div>
    </div>
    <div class="form-group">
        <label for="extras">Extras</label>
        <textarea class="form-control" id="extras" rows="3"></textarea>
    </div>
    <?php
    if(isEditing()) {
        ?>
        <div class="form-group">
            <label for="review">Review</label>
            <textarea class="form-control" id="review" rows="3"></textarea>
        </div>
        <?php
    }
    ?>
    <div class="row d-flex justify-content-center align-content-center ">
        <button class="btn btn-primary mt-2 w-25" type="submit">Submit form</button>
    </div>
</form>
<script>
    $(function () {
        $("#checkinDate").datepicker({ dateFormat: "dd-mm-yy" });
        $("#checkoutDate").datepicker({ dateFormat: "dd-mm-yy" });
    });

    const review = document.getElementById('review')
    const roomSelect = document.getElementById('roomSelect')
    const checkinDate = document.getElementById('checkinDate')
    const checkoutDate = document.getElementById('checkoutDate')
    const contactNumber = document.getElementById('contactNumber')
    const extras = document.getElementById('extras')
    const createForm = document.getElementById('createForm')
    <?php
    if (isEditing()) {
        echo "roomSelect.value = \"" . $booking['room'] . "\";\n";
        echo "$(function () {\n
            var parsedCheckinDate = $.datepicker.parseDate('yy-mm-dd', \"".$booking['checkIn']."\");
            var parsedCheckoutDate = $.datepicker.parseDate('yy-mm-dd', \"".$booking['checkOut']."\");
            $(\"#checkinDate\").datepicker(\"setDate\", parsedCheckinDate );\n
            $(\"#checkoutDate\").datepicker(\"setDate\", parsedCheckoutDate );\n
        });\n";
        echo "contactNumber.value = \"" . $booking['contactNumber'] . "\";\n";
        echo "extras.value = \"" . $booking['extras'] . "\";\n";
        echo "review.value = \"" . $booking['review'] . "\";\n";
    }
    ?>
    createForm.addEventListener('submit', event => {
        event.preventDefault()
        if (!createForm.checkValidity()) {
            event.stopPropagation()
        } else {
            (async () => {
                const response = await fetch('/booking/<?php echo isEditing() ? 'edit' : 'created' ?>', {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({<?php echo isEditing() ? "bookingID: \"".$booking['bookingID']."\", review: review.value, " : "" ?> user: "<?php echo $user->getUserID(); ?>", room: roomSelect.value, checkInDate: checkinDate.value, checkoutDate: checkoutDate.value, contactNumber: contactNumber.value, extras: extras.value})
                });
                const content = await response.json();
                if (content.message == "success") {
                    console.log(content)
                    location.href = "/bookings/" + content.booking
                }
            })();
        }

        createForm.classList.add('was-validated')
    }, false)
</script>