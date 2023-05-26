<div class="card-header">
    Our Rooms:
</div>
<ul class="list-group">
<?php
    global $conn;
    $rooms = $conn->query("SELECT * FROM room");
    foreach($rooms as $room){
        echo "
        <li class=\"list-group-item\">
            <div class=\"row\">
                <div class=\"col-12 col-lg-9\">
                    <p>Name:" . $room['roomname'] . "</p>
                    <p>Description:" . $room['description'] . "</p>
                    <p>Room Type:" . $room['roomtype'] . "</p>
                    <p>Beds:" . $room['beds'] . "</p>
                </div>
            </div>
        </li>";
    }
?>
</ul>