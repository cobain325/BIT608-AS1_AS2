<?php
session_start();
if(!isset($_SESSION['alertList'])){
    $_SESSION['alertList'] = array();
}
require_once "includes/database.php";
require_once "includes/helpers/admins.php";
require_once "includes/helpers/config.php";
if( $_SERVER['REQUEST_METHOD'] != 'POST' ) {
    include 'main.php';
} else {
    include "routes_new.php";
}
?>
