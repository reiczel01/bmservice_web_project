<link rel="stylesheet" type="text/css" href="../css/notification.css">

<?php
function notification($message)
{
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////
    /// signup: emptyinput, invalidusername, invalidemail, passwordsdontmatch, stmtfailed, usernametaken, none////
    /// login: emptyinput, wronglogin, none /////////////////////////////////////////////////////////////////////
    /// logout: successLogout, logoutFailed ///////////////////////////////////////////////////////////////////////////////////
    if ($message == "emptyinput") {
        echo '<p class="notification error">Fill in all fields!</p>';
    }
    else if ($message == "invalidusername") {
        echo '<p class="notification error">Choose a proper username!</p>';
    }
    else if ($message == "invalidemail") {
        echo '<p class="notification error">Choose a proper email!</p>';
    }
    else if ($message == "passwordsdontmatch") {
        echo '<p class="notification error">"Passwords don\'t match!"</p>';
    }
    else if ($message == "stmtfailed") {
        echo '<p class="notification error">Something went wrong, try again!</p>';
    }
    else if ($message == "usernametaken") {
        echo '<p class="notification error">Username already taken!</p>';
    }
    else if ($message == "none") {
        echo '<p class="notification success">You have signed up!</p>';
    }
    else if ($message == "wrongLogin") {
        echo '<p class="notification error">Incorrect login information!</p>';
    }
    else if ($message == "succesLogin") {
        echo '<p class="notification">You have logged in!</p>';
    }
    else if ($message == "logoutFailed") {
        echo '<p class="notification">Logout failed!</p>';
    }
    else if ($message == "successLogout") {
        echo '<p class="notification success">You have logged out!</p>';
    }
    else if ($message == "alreadyLoggedIn") {
        echo '<p class="notification">You are already logged in!</p>';
    }
    else if (empty($message)){
        exit;
    }
    else
    {
        echo '<p class="notification error">Something went wrong!</p>';
    }
}