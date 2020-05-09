<?php
session_start();

use Model\Member;
use Controller\MemberController;

require "../model/DBConnect.php";
require "../model/MemberDB.php";
require "../model/Member.php";
require "../controller/MemberController.php";
require "../validate/function.php";

$controller = new MemberController();

if (isset($_REQUEST["login-submit"])) {
    $controller->login();
}

if (isset($_REQUEST["register-submit"])) {
    $controller->register();
}

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $controller->logout();
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link rel="stylesheet" href="../css/login.css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
</head>
<body>
<?php if (isset($_SESSION['success'])): ?>
    <script>
        alert("Register is successful!")
        <?php unset($_SESSION['success']);?>
    </script>
<?php endif; ?>
<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-login">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-6">
                            <a href="#" class="active" id="login-form-link">Login</a>
                        </div>
                        <div class="col-xs-6">
                            <a href="#" id="register-form-link">Register</a>
                        </div>
                    </div>
                    <hr>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <form id="login-form" action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post" role="form"
                                  <?php if (isset($_SESSION['email-err']) || isset($_SESSION['name-err']) || isset($_SESSION['password-err']) || isset($_SESSION['confirm-password-err'])): ?>style="display: none"
                                  <?php else: ?>style="display: block"<?php endif; ?>>
                                <span style="color: red">
                                        <?php if (isset($_SESSION['login-error'])) {
                                            echo $_SESSION['login-error'];
                                            unset($_SESSION['login-error']);
                                        } ?>
                                    </span>
                                <div class="form-group">
                                    <input type="text" name="email" id="email" tabindex="1" class="form-control"
                                           placeholder="Email Address" value="">
                                    <span style="color: red">
                                        <?php if (isset($_SESSION['email-error'])) {
                                            echo $_SESSION['email-error'];
                                            unset($_SESSION['email-error']);
                                        } ?>
                                    </span>
                                </div>
                                <div class="form-group">
                                    <input type="password" name="password" id="password" tabindex="2"
                                           class="form-control" placeholder="Password">
                                    <span style="color: red">
                                        <?php if (isset($_SESSION['password-error'])) {
                                            echo $_SESSION['password-error'];
                                            unset($_SESSION['password-error']);
                                        } ?>
                                    </span>
                                </div>
                                <div class="form-group text-center">
                                    <input type="checkbox" tabindex="3" class="" name="remember" id="remember">
                                    <label for="remember"> Remember Me</label>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-6 col-sm-offset-3">
                                            <input type="submit" name="login-submit" id="login-submit" tabindex="4"
                                                   class="form-control btn btn-login" value="Log In">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="text-center">
                                                <a href="" tabindex="5"
                                                   class="forgot-password">Forgot Password?</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <form id="register-form" action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post"
                                  role="form"
                                  <?php if (isset($_SESSION['email-err']) || isset($_SESSION['name-err']) || isset($_SESSION['password-err']) || isset($_SESSION['confirm-password-err'])): ?>style="display: block"
                                  <?php else: ?>style="display: none"<?php endif; ?>
                            >
                                <div class="form-group">
                                    <input type="email" name="email" id="email" tabindex="1" class="form-control"
                                           placeholder="Email Address" value="<?php if (isset($_SESSION['email'])) {
                                        echo $_SESSION['email'];
                                        unset($_SESSION['email']);
                                    } ?>">
                                    <span style="color: red">
                                        <?php if (isset($_SESSION['email-err'])) {
                                            echo $_SESSION['email-err'];
                                            unset($_SESSION['email-err']);
                                        } ?>
                                    </span>
                                </div>
                                <div class="form-group">
                                    <input type="text" name="name" id="name" tabindex="1" class="form-control"
                                           placeholder="Nickname" value="<?php if (isset($_SESSION['name'])) {
                                        echo $_SESSION['name'];
                                        unset($_SESSION['name']);
                                    } ?>"
                                    >
                                    <span style="color: red">
                                        <?php if (isset($_SESSION['name-err'])) {
                                            echo $_SESSION['name-err'];
                                            unset($_SESSION['name-err']);
                                        } ?>
                                </div>
                                <div class="form-group">
                                    <input type="password" name="password" id="password" tabindex="2"
                                           class="form-control" placeholder="Password">
                                    <span style="color: red">
                                        <?php if (isset($_SESSION['password-err'])) {
                                            echo $_SESSION['password-err'];
                                            unset($_SESSION['password-err']);
                                        } ?>
                                    </span>
                                </div>
                                <div class="form-group">
                                    <input type="password" name="confirm-password" id="confirm-password" tabindex="2"
                                           class="form-control" placeholder="Confirm Password">
                                    <span style="color: red">
                                        <?php if (isset($_SESSION['confirm-password-err'])) {
                                            echo $_SESSION['confirm-password-err'];
                                            unset($_SESSION['confirm-password-err']);
                                        } ?>
                                    </span>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-6 col-sm-offset-3">
                                            <input type="submit" name="register-submit" id="register-submit"
                                                   tabindex="4" class="form-control btn btn-register"
                                                   value="Register Now">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(function () {
        $('#login-form-link').click(function (e) {
            $("#login-form").delay(100).fadeIn(100);
            $("#register-form").fadeOut(100);
            $('#register-form-link').removeClass('active');
            $(this).addClass('active');
            e.preventDefault();
        });
        $('#register-form-link').click(function (e) {
            $("#register-form").delay(100).fadeIn(100);
            $("#login-form").fadeOut(100);
            $('#login-form-link').removeClass('active');
            $(this).addClass('active');
            e.preventDefault();
        });
    });
</script>
</body>
</html>