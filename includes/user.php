<?php
class User {
    private $customerID;
    private $userType;
    private $firstname;
    private $lastname;
    private $email;
    private $password;

    function __construct($firstname = "Guest", $userType = "Guest") {
        $this->firstname = $firstname;
        $this->userType = $userType;
        $_SESSION['user'] = serialize($this);
    }

    function getUserType(){
        return $this->userType;
    }
    function getCustomerName(){
        return $this->firstname . $this->lastname;
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