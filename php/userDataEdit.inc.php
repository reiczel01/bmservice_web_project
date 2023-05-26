<?php

include_once 'dbHandler.inc.php';

if (isset($_POST['data_id'], $_POST['user_id'], $_POST['first_name'], $_POST['last_name'], $_POST['company_name'], $_POST['vat_id'], $_POST['address'], $_POST['phone_number'])) {
    // Pobierz dane z formularza
    $dataId = $_POST['data_id'];
    $userId = $_POST['user_id'];
    $firstName = $_POST['first_name'];
    $lastName = $_POST['last_name'];
    $companyName = $_POST['company_name'];
    $vatId = $_POST['vat_id'];
    $address = $_POST['address'];
    $phoneNumber = $_POST['phone_number'];

    // Przygotuj zapytanie SQL do aktualizacji danych użytkownika
    $query = "UPDATE users_data SET first_name = ?, last_name = ?, company_name = ?, vat_id = ?, address = ?, phone_number = ? WHERE data_id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "ssssssi", $firstName, $lastName, $companyName, $vatId, $address, $phoneNumber, $dataId);
    mysqli_stmt_execute($stmt);
    //var_dump($dataId);
    // Przekieruj z powrotem do strony admina
    header("Location: /adminPanelUsersData.php?success=userupdated?data_id=$dataId");
    exit();
} else {
    // Jeżeli dane z formularza nie są ustawione, przekieruj z powrotem do strony admina z komunikatem o błędzie
    header("Location: /adminPanelUsersData.php?error=nouserdata");
    exit();
}
