<?php
global $conn;
global $route;
global $user;
function isEditing()
{
    $route = rtrim($_SERVER['REQUEST_URI'], '/');
    $route = explode('/', $route);
    if (!empty($route[3]) && $route[3] == 'edit') {
        return true;
    } else {
        return false;
    }
}
if($user->getUserType() == "Guest") {
    ?><div class="alert alert-danger" role="alert">
        Please login first.
    </div><script>
        loginModal.show();</script>
        <?php
} else {
?>
<div class="card-header">
    <?php
    $rooms = mysqli_query($conn, "SELECT * FROM room");
    if (isEditing()) {
        echo "<h4>Edit Booking</h4>";
    } else {
        echo "<h4>Create Booking</h4>";
    }
    ?>
</div>
<div class="card-body">
    <h5 class="card-title" style="display: flex; justify-content: space-between;">
        <div>Booking for
            <?php
            if (isEditing()) {
                echo $booking['firstname'] . " " . $booking['lastname'];
            } else {
                echo $user->getCustomerName();
            }
            ?>
        </div>
        <div>
            <?php
            if (isEditing()) {
                echo "<a class=\"btn btn-outline-danger\" href=\"/bookings/" . $booking['bookingID'] . "/delete\" role=\"button\">Delete Booking</a>";
            }
            ?>
        </div>
    </h5>
    <form class="needs-validation card-text" id="createForm" novalidate>
        <div class="form-group">
            <label for="checkinDate">Checkin Date</label>
            <input class="form-control" id="checkinDate" autocomplete="off" required />
            <div class="invalid-feedback">
                Please choose a checkin date.
            </div>
        </div>
        <div class="form-group">
            <label for="checkoutDate">Checkout Date</label>
            <input class="form-control" id="checkoutDate" autocomplete="off" required />
            <div class="invalid-feedback">
                Please choose a checkout date.
            </div>
        </div>
        <div class="form-group">
            <label for="roomSelect">Room (name, type, beds)</label>
            </br>
            <span>Available rooms for selected dates</span>
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
            <label for="contactNumber">Contact Number</label>
            <input class="form-control" type="tel" id="contactNumber" pattern='^(\+?\d{2})?([\s]?[\-]?[\d]+){8,15}([\s])*' required />
            <div class="invalid-feedback">
                Please enter a valid contact number.
            </div>
        </div>
        <div class="form-group">
            <label for="extras">Extras</label>
            <textarea class="form-control" id="extras" rows="3"></textarea>
        </div>
        <?php
        if (isEditing()) {
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

</div>
<script>
    $(function () {
        $("#checkinDate").datepicker({ dateFormat: "dd-mm-yy"});
        $("#checkoutDate").datepicker({ dateFormat: "dd-mm-yy"});
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
            var parsedCheckinDate = $.datepicker.parseDate('yy-mm-dd', \"" . $booking['checkIn'] . "\");
            var parsedCheckoutDate = $.datepicker.parseDate('yy-mm-dd', \"" . $booking['checkOut'] . "\");
            $(\"#checkinDate\").datepicker(\"setDate\", parsedCheckinDate );\n
            $(\"#checkoutDate\").datepicker(\"setDate\", parsedCheckoutDate );\n
            checkRoom();\n
        });\n";
        echo "contactNumber.value = \"" . $booking['contactNumber'] . "\";\n";
        echo "extras.value = \"" . $booking['extras'] . "\";\n";
        echo "review.value = \"" . $booking['review'] . "\";\n";
    } else {
        echo '
        $("#checkinDate").datepicker("option",{ minDate: 0});
        $("#checkoutDate").datepicker("option",{ minDate: 1});
        ';
    }
    ?>
    $('#checkinDate').datepicker()
        .on("input change", event => {
            event.preventDefault()
            if ($('#checkoutDate').val() == "" || $('#checkinDate') == "") {
                event.stopPropagation()
            } else {
                checkRoom();
            }
        })
    $('#checkoutDate').datepicker()
        .on("input change", event => {
            event.preventDefault()
            if ($('#checkoutDate').val() == "" || $('#checkinDate') == "") {
                event.stopPropagation()
            } else {
                checkRoom();
            }
        })
    async function checkRoom() {
        const roomSelect = $("#roomSelect");
        roomSelect.html('<option selected disabled value="">Getting available rooms. Please wait...</option>');
        const response = await fetch('/booking/check', {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({<?php echo isEditing() ? "bookingID: " . $booking['bookingID'] .",": "" ?> checkInDate: checkinDate.value, checkoutDate: checkoutDate.value})
    });
    const content = await response.json();
    if (content.message == "success") {
        if (content.result.length > 0) {
            let options = '';
            $.each(content.result, function (i, p) {
                options += '<option value="' + p[0] + '">' + p[1] + ', ' + p[3] + ', ' + p[4] + '</option>';
            });
            roomSelect.html('<option selected disabled value="">Please select a room</option>' + options);
            if ($("#roomSelect option[value='<?php echo isEditing() ? $booking['room'] : "" ?>']").length > 0) {
                roomSelect.val("<?php echo isEditing() ? $booking['room'] : "" ?>").change();
            }
        } else {
            roomSelect.html(('<option selected disabled value="">No rooms available. Please select different dates.</option>'));
        }
    }
    }

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
                    body: JSON.stringify({<?php echo isEditing() ? "bookingID: \"" . $booking['bookingID'] . "\", review: review.value, " : "" ?> user : "<?php echo $user->getUserID(); ?>", room: roomSelect.value, checkInDate: checkinDate.value, checkoutDate: checkoutDate.value, contactNumber: contactNumber.value, extras: extras.value})
            });
            const content = await response.json();
            if (content.message == "success") {
                location.href = "/bookings/" + content.booking
            } else {
                //add error handling.
                console.log(content)
            }
        })();
        }

    createForm.classList.add('was-validated')
    }, false)
</script>
<?php 
}
?>