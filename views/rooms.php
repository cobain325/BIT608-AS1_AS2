<?php
    global $conn;
    $rooms = $conn->query("SELECT * FROM room");
    foreach($rooms as $room){
        echo var_dump($room);
    }
?>