<?php
include_once 'php/dbHandler.inc.php'; // Zaimportuj połączenie z bazą danych
include_once 'php/functions.inc.php'; // Zaimportuj plik z funkcją getUserDataWithRoles
session_start();

$data_id = $_GET['data_id'];
if(isset($_SESSION["userid"]) && $_SESSION["role"] === "admin") {
//var_dump($data_id);
    include_once 'dbHandler.inc.php';
    include_once 'functions.inc.php';
    // Wykonaj operacje usuwania użytkownika o podanym identyfikatorze
    $out = deleteUserData($conn, $data_id);
    if($out == true){
        header("Location: /adminPanelUsersData.php?success");
    }else{
        header("Location: /adminPanelUsersData.php?error");
    }
}else{
    header("Location: /index.php");
}
exit();
