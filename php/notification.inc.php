<?php
function notification($message)
{
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////
    /// signup: emptyinput, invalidusername, invalidemail, passwordsdontmatch, stmtfailed, usernametaken, none////
    /// login: emptyinput, wronglogin, none /////////////////////////////////////////////////////////////////////
    /// logout: successLogout, logoutFailed ///////////////////////////////////////////////////////////////////////////////////
    if ($message == "emptyinput") {
        echo "<p>Fill in all fields!</p>";
    }
    else if ($message == "invalidusername") {
        echo "<p>Choose a proper username!</p>";
    }
    else if ($message == "invalidemail") {
        echo "<p>Choose a proper email!</p>";
    }
    else if ($message == "passwordsdontmatch") {
        echo "<p>Passwords don't match!</p>";
    }
    else if ($message == "stmtfailed") {
        echo "<p>Something went wrong, try again!</p>";
    }
    else if ($message == "usernametaken") {
        echo "<p>Username already taken!</p>";
    }
    else if ($message == "none") {
        echo "<p>You have signed up!</p>";
    }
    else if ($message == "wronglogin") {
        echo "<p>Incorrect login information!</p>";
    }
    else if ($message == "successLogin") {
        echo "<p>You have logged out!</p>";
    }
    else if ($message == "logoutFailed") {
        echo "<p>Logout failed!</p>";
    }
    else if ($message == "successLogout") {
        echo "<p>You have logged out!</p>";
    }
    else
    {
        echo "<p>Something went wrong!</p>";
    }
}