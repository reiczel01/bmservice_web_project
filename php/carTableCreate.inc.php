<?php
session_start();
if(isset($_SESSION["userid"])) {
    include_once 'dbHandler.inc.php';
    include_once 'functions.inc.php';
    $user_id = $_SESSION["userid"];
    // Pobranie danych z bazy danych
    $carsData = createTwoDimensionalArrayOfCars($conn, $user_id);

    // Przejście przez dane i wypełnienie tabeli
    echo '
        <link rel="stylesheet" type="text/css" href="../css/data-table.css">

        <table>
            <thead>
                <tr>
                    <th>Model</th>
                    <th>Silnik</th>
                    <th>Numer rejestracyjny</th>
                    <th>Numer VIN</th>
                    <th>Rok produkcji</th>
                </tr>
            </thead>
            <tbody>';
    foreach ($carsData as $car) {
        echo '<tr>
                  <td>'.$car["model"].'</td>
                  <td>'.$car["make"].'</td>
                  <td>'.$car["registration_nr"].'</td>
                  <td>'.$car["vin"].'</td>
                  <td>'.$car["production_year"].'</td>
              </tr>';
    }
    echo '</tbody></table>';
} else {
    exit;
}

