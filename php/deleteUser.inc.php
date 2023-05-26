<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

$user_id = $_GET['user_id'];
if(isset($_SESSION["userid"]) && $_SESSION["role"] === "admin" && $user_id != $_SESSION['userid']) {

    include_once 'dbHandler.inc.php';
    include_once 'functions.inc.php';
    // Wykonaj operacje usuwania użytkownika o podanym identyfikatorze
    deleteUser($conn, $user_id);
    header("Location: /adminPanelUsers.php&success");
    }else{
        header("Location: /index.php");
}
    exit();
