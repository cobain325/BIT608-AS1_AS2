<?php

declare(strict_types=1);
use Firebase\JWT\JWT;

require_once('vendor/autoload.php');
class User
{
    private $customerID;
    private $userType;
    private $firstname;
    private $lastname;
    private $email;
    private $status;
    private $token;

    function __construct($customerID = null, $userType = null, $firstname = null, $lastname = null, $email = null, $status = null, $token = null)
    {
        if ($email == null || $userType == null) {
            $this->customerID = null;
            $this->userType = "Guest";
            $this->firstname = "Guest";
            $this->lastname = "";
            $this->email = "";
            $this->status = "";
            $this->token = "";
        } else {
            $this->customerID = $customerID;
            $this->userType = $userType;
            $this->firstname = $firstname;
            $this->lastname = $lastname;
            $this->email = $email;
            $this->status = $status;
            $this->token = $token;
        }
    }

    function authorize($email, $password)
    {

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
                global $admins;
                if (in_array((int) $user['customerID'], $admins)) {
                    $this->userType = "Admin";
                } else {
                    $this->userType = "Customer";
                }
                $this->firstname = $user['firstname'];
                $this->lastname = $user['lastname'];
                $this->email = $user['email'];

                global $secret_Key;
                global $domainName;
                $date = new DateTimeImmutable();
                $expire_at = $date->modify('+1 day')->getTimestamp(); // Add 1 day
                $request_data = [
                    'iat' => $date->getTimestamp(),
                    // Issued at: time when the token was generated
                    'iss' => $domainName,
                    // Issuer
                    'nbf' => $date->getTimestamp(),
                    // Not before
                    'exp' => $expire_at,
                    // Expire
                    'firstname' => $this->firstname, // first name
                ];

                $this->token = JWT::encode(
                    $request_data,
                    $secret_Key,
                    'HS512'
                );
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
            } else {
                $this->status = 'Invalid Password';
            }
        } else {
            $this->status = "User not found";
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

    function getUserToken()
    {
        return $this->token;
    }

    function checkAuth()
    {
        if (key_exists('HTTP_AUTHORIZATION', $_SERVER)) {
            if (!preg_match('/Bearer\s(\S+)/', $_SERVER['HTTP_AUTHORIZATION'], $matches)) {
                $this->status = 'Token not found in request';
                return false;
            }
            $jwt = $matches[1];
            if (!$jwt) {
                // No token was able to be extracted from the authorization header
                $this->status = 'Token not found in request';
                return false;
            }
            global $secret_Key;
            global $domainName;
            try {
                $token = JWT::decode($jwt, $secret_Key, ['HS512']);
            } catch (Exception $e) {
                var_dump($e);
            }
            $now = new DateTimeImmutable();
            if (
                $token->iss !== $domainName ||
                $token->nbf > $now->getTimestamp() ||
                $token->exp < $now->getTimestamp()
            ) {
                $this->status = 'Unauthorized';
                if (isset($_SESSION['user'])) {
                    unset($_SESSION['user']);
                }
                global $user;
                $user = new User();
                return false;
            } else {
                return true;
            }
        } else {
            $this->status = "Unauthorized";
            return false;
        }
    }
}
?>