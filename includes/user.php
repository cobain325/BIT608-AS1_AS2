<?php
class User
{
    private $customerID;
    private $userType;
    private $firstname;
    private $lastname;
    private $email;

    function __construct($email = null, $password = null)
    {
        if ($email == null || $password == null) {
            $this->customerID = null;
            $this->userType = "Guest";
            $this->firstname = "Guest";
            $this->lastname = "";
            $this->email = "";
        } else {
            global $conn;
            $user = $conn->query('SELECT * FROM customer WHERE email = "' . $email . '"');
            if ($user) {
                $user = $user->fetch_assoc();
                if (password_verify($password, $user['password'])) {
                    $this->customerID = $user['customerID'];
                    if ($user['customerID'] == 1) {
                        $this->userType = "Admin";
                    } else {
                        $this->userType = "Customer";
                    }
                    $this->firstname = $user['firstname'];
                    $this->lastname = $user['lastname'];
                    $this->email = $user['email'];
                    $_SESSION['user'] = serialize($this);
                } else if ($password == $user['password']) {

                // Override to change existing db customers to hashed passwords
                // All hashed passwords are set to "test"
                    $conn->query('UPDATE customer SET password = "' . password_hash($password, PASSWORD_DEFAULT) . '" WHERE customerID = ' . $user['customerID']);
                    $this->customerID = $user['customerID'];
                    if ($user['customerID'] == 1) {
                        $this->userType = "Admin";
                    } else {
                        $this->userType = "Customer";
                    }
                    $this->firstname = $user['firstname'];
                    $this->lastname = $user['lastname'];
                    $this->email = $user['email'];
                    $_SESSION['user'] = serialize($this);
                }
            }
        }
    }

    function getUserType()
    {
        return $this->userType;
    }
    function getFirstName()
    {
        return $this->firstname;
    }
    function getCustomerName()
    {
        return $this->firstname . " " . $this->lastname;
    }
    function getUserID()
    {
        return $this->customerID;
        ;
    }
}
?>