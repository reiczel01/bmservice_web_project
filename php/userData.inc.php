<?php

if (isset($_POST["carRegistration-submit"])) {
    $first_name = $_POST["first_name"];
    $last_name = $_POST["last_name"];
    $company_name = isset($_POST["company_name"]) ? $_POST["company_name"] : null;
    $vat_id = isset($_POST["vat_id"]) ? $_POST["vat_id"] : null;
    $address = $_POST["address"];
    $phone_number = $_POST["phone_number"];

    // Wykonaj weryfikację danych, jeśli jest to wymagane

    require_once 'dbHandler.inc.php';
    require_once 'functions.inc.php';

    checkSession();

    if (isUserLoggedIn()) {
        header("Location: /userData.php?error=notloggedin");
        exit();
    }


    // Wywołaj funkcję registerUserData, która zarejestruje dane użytkownika
    registerUserData($conn, $_SESSION["userid"], $first_name, $last_name, $company_name, $vat_id, $address, $phone_number);
    header("Location: /userData.php?error=none");
}
