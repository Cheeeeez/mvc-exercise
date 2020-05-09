<?php

namespace Controller;

use Model\Member;
use Model\MemberDB;
use Model\DBConnect;

class MemberController
{
    public $memberDB;

    public function __construct()
    {
        $conn = new DBConnect("mysql:host=localhost;dbname=classicmodels", "root", "Khongba0.");
        $this->memberDB = new MemberDB($conn->connect());
    }

    public function login()
    {
        $loginEmail = $_REQUEST["email"];
        $loginPassword = $_REQUEST["password"];

        if (empty($_REQUEST["email"])) {
            $_SESSION['email-error'] = "*Email is required";
        } elseif (empty($_REQUEST["password"])) {
            $_SESSION['password-error'] = "*Password is required";
        } else {
            $result = $this->memberDB->get($loginEmail, $loginPassword);
            if (!empty($result)) {
                $_SESSION["user"] = $result;
                header("Location: ../");
            } else {
                $_SESSION['login-error'] = "*Email or password is incorrect";
            }
        }
    }

    public function register()
    {
        $error = 0;

        if (empty($_REQUEST["email"])) {
            $_SESSION['email-err'] = "*Email is required";
            $error++;
        } else {
            if (checkEmail($_REQUEST["email"])) {
                $email = $_REQUEST["email"];
                $_SESSION['email'] = $email;
            } else {
                $_SESSION['email-err'] = "*Invalid email format";
                $error++;
            }
        }

        if (empty($_REQUEST["name"])) {
            $_SESSION['name-err'] = "*Nickname is required";
            $error++;
        } else {
            $name = $_REQUEST["name"];
            $_SESSION['name'] = $name;
        }

        if (empty($_REQUEST["password"])) {
            $_SESSION['password-err'] = "*Password is required";
            $error++;
        } else {
            if (checkPassword($_REQUEST["password"])) {
                $passWord = $_REQUEST["password"];
            } else {
                $_SESSION['password-err'] = "*Password must be use 8 or more characters with a mix of letters, numbers & one of these symbols (@, !, ^, -, %, $)";
                $error++;
            }
        }

        if (empty($_REQUEST["confirm-password"])) {
            $_SESSION['confirm-password-err'] = "*Confirm password is required";
            $error++;
        } elseif ($_REQUEST["confirm-password"] != $_REQUEST["password"]) {
            $_SESSION['confirm-password-err'] = "*Confirm your password";
            $error++;
        }

        if ($error == 0) {
            $member = new Member($email, $name, $passWord);
            $_SESSION['success'] = true;
            $this->memberDB->create($member);
        }
    }

    public function logout()
    {
        unset($_SESSION['user']);
    }

    public function index()
    {
        if (!isset($_SESSION['user'])) {
            header('Location: view/login.php');
        }
    }
}