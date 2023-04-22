<?php
if (isset($_POST["signup_btn"])) {
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $passwordRepeat = $_POST["passwordRepeat"];

    require_once 'dbHandler.inc.php';
    require_once 'functions.inc.php';

    if (emptyInputSignup( $username, $email, $password, $passwordRepeat) !== false) {
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

    createUser($conn, $username, $email, $password);


} else {
    header("Location: ../index.php");
}
