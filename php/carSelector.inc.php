<?php

session_start();
if (isset($_SESSION["userid"])) {
    include_once 'dbHandler.inc.php';
    include_once 'functions.inc.php';
    $user_id = $_SESSION["userid"];
    // Pobranie danych z bazy danych
    $carsData = createTwoDimensionalArrayOfCars($conn, $user_id);
    // Przejście przez dane i wypełnienie tabeli
    echo '<select class="input-field" name="carId">';
    foreach ($carsData as $car) {
        echo '<option style="background: #2b343b;" value="'.$car["car_id"].'">' . $car["model"] . " " . $car["registration_nr"] . '</option>';
    }
    echo '</select>';
} else {
    exit;
}