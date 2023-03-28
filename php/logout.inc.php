<?php
if(isset($_POST["logout_btn"])) {
    session_start();
    session_unset();
    session_destroy();
    header("Location: ../login.php?error=successLogout");
} else {
    header("Location: ../index.php?error=logoutFailed");
}
exit();
