<?php

declare(strict_types=1);
use Firebase\JWT\JWT;

require_once('../vendor/autoload.php');
class User
{
    private $customerID;
    private $userType;
    private $firstname;
    private $lastname;
    private $email;
    private $status;
    private $token;

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
                $this->status = "Database Error"; //$stmt->error;
            }
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result && $result->num_rows > 0) {
                $user = $result->fetch_assoc();
                if (password_verify($password, $user['password'])) {
                    $this->customerID = $user['customerID'];
                    require_once "helpers/admins.php";
                    if (in_array((int) $user['customerID'], $admins)) {
                        $this->userType = "Admin";
                    } else {
                        $this->userType = "Customer";
                    }
                    $this->firstname = $user['firstname'];
                    $this->lastname = $user['lastname'];
                    $this->email = $user['email'];
                    $_SESSION['user'] = serialize($this);

                    $secret_Key = '655add7cd5a307b31c5856f2c9572cff';
                    $date = new DateTimeImmutable();
                    $expire_at = $date->modify('+6 minutes')->getTimestamp(); // Add 60 seconds
                    $domainName = "bit608.azurewebsites.net";
                    $request_data = [
                        'iat' => $date->getTimestamp(),
                        // Issued at: time when the token was generated
                        'iss' => $domainName,
                        // Issuer
                        'nbf' => $date->getTimestamp(),
                        // Not before
                        'exp' => $expire_at,
                        // Expire
                        'firstname' => $firstname, // first name
                    ];

                    $this->token = JWT::encode(
                        $request_data,
                        $secret_Key,
                        'HS512'
                    );
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
                } else {
                    $this->status = 'Invalid Password';
                }
            } else {
                $this->status = "User not found";
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

    function getUserToken(){
        return $this->token;
    }
}
?>