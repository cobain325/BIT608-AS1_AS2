<?php
class User {
    private $userType;
    private $username;

    function __construct($username = "Guest", $userType = "Guest") {
        $this->username = $username;
        $this->userType = $userType;
    }

    function getUserType(){
        return $this->userType;
    }
    function getUsername(){
        return $this->username;
    }
    function setUserType($type){
        $this->userType = $type;
    }
}
?>