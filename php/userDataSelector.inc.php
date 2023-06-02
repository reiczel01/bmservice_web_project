<?php

session_start();
if (isset($_SESSION["userid"])) {
    include_once 'dbHandler.inc.php';
    include_once 'functions.inc.php';
    $user_id = $_SESSION["userid"];
    // Pobranie danych z bazy danych
    $usersData = getUsersDataById($conn, $user_id);


    // Przejście przez dane i wypełnienie listy rozwijanej
    echo '<select class="input-field" name="dataId">';
    foreach ($usersData as $userData) {
        $displayValue = !empty($userData["company_name"]) ? $userData["company_name"] : $userData["first_name"] . " " . $userData["last_name"];
        echo '<option style="background: #2b343b;" value="'.$userData["data_id"].'">' . $displayValue . '</option>';
    }
    echo '</select>';
} else {
    exit;
}
