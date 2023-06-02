<?php
session_start();

if (isset($_POST["carRegistration-submit"])) {
    $carId = $_POST["carId"];
    $dataId = $_POST["dataId"];
    $mileage = $_POST["milage"];
    $dateRequested = $_POST["date"];
    $description = $_POST["description"];
    include_once 'functions.inc.php';
    include_once 'dbHandler.inc.php';

    // Sprawdzenie, czy wszystkie pola zostały wypełnione
    if (empty($carId) || empty($mileage) || empty($dateRequested)) {
        //header("Location: /error.php?message=emptyfields");
        var_dump($_POST);
        exit();
    }

    // Połączenie z bazą danych
    include_once 'dbHandler.inc.php';

    // Dodanie zgłoszenia serwisowego
    if (addServiceRequest($conn, $carId, $dataId, $description, $dateRequested, $mileage)) {
        header("Location: /serviceHistory.php?message=servicerequestadded");
        exit();
    } else {
        header("Location: /serviceHistory.php?message=servicerequesterror");
        exit();
    }
} else {
    header("Location: /serviceHistory.php?message=invalidrequest");
    exit();
}
