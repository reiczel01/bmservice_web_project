<?php

include_once 'dbHandler.inc.php';

if (isset($_POST['car_id'], $_POST['make'], $_POST['model'], $_POST['vin'], $_POST['registration_nr'], $_POST['production_year'])) {
    // Pobierz dane z formularza
    $carId = $_POST['car_id'];
    $make = $_POST['make'];
    $model = $_POST['model'];
    $vin = $_POST['vin'];
    $registrationNr = $_POST['registration_nr'];
    $productionYear = $_POST['production_year'];

    // Przygotuj zapytanie SQL do aktualizacji danych samochodu
    $query = "UPDATE cars SET make = ?, model = ?, vin = ?, registration_nr = ?, production_year = ? WHERE car_id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "sssssi", $make, $model, $vin, $registrationNr, $productionYear, $carId);
    mysqli_stmt_execute($stmt);

    // Przekieruj z powrotem do strony admina
    header("Location: /adminPanelCarData.php?success=carupdated");
    exit();
} else {
    // Jeżeli dane z formularza nie są ustawione, przekieruj z powrotem do strony admina z komunikatem o błędzie
    header("Location: /adminPanelCarData.php?error=nocardata");
    exit();
}
