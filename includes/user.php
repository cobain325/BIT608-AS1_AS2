<?php
class User {
    private $userType;
    private $username;

    function __construct($username = "Guest", $userType = "Guest") {
        $this->username = $username;
        $this->userType = $userType;
        $_SESSION['user'] = serialize($this);
    }

    function getUserType(){
        return $this->userType;
    }
    function getUsername(){
        return $this->username;
    }
    function getUserID(){
        return 20;
    }
    function setUserType($type){
        $this->userType = $type;
        $_SESSION['user'] = serialize($this);
    }
}
?>