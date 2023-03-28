<?php
if (isset($_POST["signup_btn"])) {
    $first_name = $_POST["name"];
    $last_name = $_POST["surname"];
    $username = $_POST["username"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $address = $_POST["address"];
    $password = $_POST["password"];
    $passwordRepeat = $_POST["passwordRepeat"];
    $is_admin = 0;

    require_once 'dbHandler.inc.php';
    require_once 'functions.inc.php';

    if (emptyInputSignup($first_name, $last_name, $username, $email, $phone, $address, $password, $passwordRepeat) !== false) {
        header("Location: ../signup.php?error=emptyinput");
        exit();
    }

    if (invalidUid($username) !== false) {
        header("Location: ../signup.php?error=invaliduid");
        exit();
    }

    if (invalidEmail($email) !== false) {
        header("Location: ../signup.php?error=invalidemail");
        exit();
    }

    if (passMatch($password, $passwordRepeat) !== false) {
        header("Location: ../signup.php?error=passwordsdontmatch");
        exit();
    }

    if (uidExists($conn, $username, $email) !== false) {
        header("Location: ../signup.php?error=usernametaken");
        exit();
    }

    createUser($conn, $first_name, $last_name, $username, $email, $phone, $address, $password, $is_admin);


} else {
    header("Location: ../index.php");
}
