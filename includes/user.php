<?php
class User
{
    private $customerID;
    private $userType;
    private $firstname;
    private $lastname;
    private $email;
    private $status;

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
            $query = "SELECT * FROM customer WHERE email = ?";
            $stmt = $conn->prepare($query);
            if (!$stmt) {
                $this->status = $stmt->error;
            }
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result && $result->num_rows > 0) {
                $user = $result->fetch_assoc();
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
                    // All hashed passwords are set to "."
                    $query = "UPDATE customer SET password = ? WHERE customerID = ?";
                    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                    $stmt = $conn->prepare($query);
                    $stmt->bind_param("si", $hashedPassword, $user['customerID']);
                    $stmt->execute();
                    
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
                else {
                    $this->status = 'Invalid Password';
                }
            } else {
                $this->status = $conn->error;
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
    }   
    function getUserStatus()
    {
        return $this->status;
    }
}
?>