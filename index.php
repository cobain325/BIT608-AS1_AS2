<?php 
session_start();
if(!isset($_SESSION['alertList'])){
    $_SESSION['alertList'] = array();
}
require_once "includes/database.php";
if( $_SERVER['REQUEST_METHOD'] != 'POST' ) {
    include 'main.php';
} else {
    include 'routes.php';
}
?>
