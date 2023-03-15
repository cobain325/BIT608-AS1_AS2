<?php

require_once __DIR__.'/router.php';

get('/', function() { include "views/home.php"; });
get('/privacy', function() { include "views/privacy.php"; });
get('/bookings', function() { include "views/bookings.php"; });
get('/bookings/$bookingID', function($bookingID) { include "views/booking_details.php"; });
get('/bookings/$bookingID/edit', function($bookingID) { include "views/booking_details.php"; });
get('/bookings/$bookingID/delete', function($bookingID) { include "views/booking_details.php"; });
get('/bookings/create', function() {  include "views/bookings.php"; });
get('/rooms', function() { include "views/rooms.php"; });

any('/404', "views/404.php");