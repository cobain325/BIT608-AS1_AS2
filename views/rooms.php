<?php
    global $conn;
    $rooms = mysqli_query($conn, "SELECT * FROM room");
    foreach($rooms as $room){
        echo var_dump($room);
    }

?>