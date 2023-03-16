<?php
global $user;
global $conn;
$rooms = mysqli_query($conn, "SELECT * FROM room");
?>
<h4>Make a Booking</h4>
<h5>Booking for
    <?php echo $user->getCustomerName(); 
    echo $user->getUserID();
    ?>
</h5>
<form class="needs-validation" novalidate>
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
        <label for="checkInDate">Checkin Date</label>
        <input class="form-control" id="checkInDate" required />
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
        <div class=" row d-flex justify-content-center align-content-center ">
            <button class="btn btn-primary mt-2 w-25" type="submit">Submit form</button>
        </div>
    </div>
</form>
<script>
  $( function() {
    $( "#checkInDate" ).datepicker({dateFormat: "dd-mm-yy"});
  } );
  $( function() {
    $( "#checkoutDate" ).datepicker({dateFormat: "dd-mm-yy"});
  } );
    const form = document.querySelector('.needs-validation')
    form.addEventListener('submit', event => {
            event.preventDefault()
        if (!form.checkValidity()) {
            event.stopPropagation()
        } else {
            (async () => {
                const roomSelect = document.getElementById('roomSelect')
                const checkInDate = document.getElementById('checkInDate')
                const checkoutDate = document.getElementById('checkoutDate')
                const contactNumber = document.getElementById('contactNumber')
                const extras = document.getElementById('extras')
                const response = await fetch('/booking/created', { <?php //$_SERVER['SERVER_ADDR'] ?>
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({user: "<?php echo $user->getUserID(); ?>", room: roomSelect.value, checkInDate: checkInDate.value, checkoutDate: checkoutDate.value, contactNumber: contactNumber.value, extras: extras.value})
                });
                const content = await response.json();
                if(content.message == "success") {
                    console.log(content)
                    location.href = "/bookings/" + content.booking
                }
            })();
        }

        form.classList.add('was-validated')
    }, false)
</script>