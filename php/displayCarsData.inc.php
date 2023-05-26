<?php
session_start();
if (isset($_SESSION["userid"])) {
    include_once 'dbHandler.inc.php';
    include_once 'functions.inc.php';
    $car_id = $_SESSION["userid"];

    $carsData = getAllCars($conn);
    //var_dump($carsData);
    foreach ($carsData as $car) {
        echo '
        <tr>
            <td>' . $car["user_id"] . '</td>
            <td>' . $car["make"] . '</td>
            <td>' . $car["model"] . '</td>
            <td>' . $car["vin"] . '</td>
            <td>' . $car["registration_nr"] . '</td>
            <td>' . $car["production_year"] . '</td>
            <td style="padding: 1rem">
                <a href="../adminCarDataEdit.php?car_id=' . $car["car_id"] . '" class="btn"> <span class="material-symbols-outlined">edit</span></a>
                <a href="php/deleteCarData.inc.php?car_id=' . $car["car_id"] . '" class="btn-danger"><span class="material-symbols-outlined">delete_forever</span></a>
            </td>
        </tr>';
    }
} else {
    exit;
}
