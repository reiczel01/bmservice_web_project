<?php
include_once 'dbHandler.inc.php'; // Zaimportuj połączenie z bazą danych
include_once 'functions.inc.php'; // Zaimportuj plik z funkcją getUserDataWithRoles

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


// Sprawdź, czy formularz został wysłany
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $request_id = secure_input($conn, $_POST['request_id']);
    $request_description = secure_input($conn, $_POST['request_description']);
    $realisation_description = secure_input($conn, $_POST['realisation_description']);
    $milage = secure_input($conn, $_POST['milage']);
    $date_requested = secure_input($conn, $_POST['date_requested']);
    $date_realised = secure_input($conn, $_POST['date_realised']);
    $technican_username = secure_input($conn, $_POST['technican_username']);

    $technican_data = getUserDataByUsername($conn, $technican_username);


    $query = "UPDATE service_requests SET description = '$request_description', date_requested = '$date_requested', milage = '$milage' WHERE request_id = '$request_id'";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        echo "3";
        return false;
    }

    $query = "SELECT * FROM service_realisations WHERE request_id = '$request_id'";
    $result = mysqli_query($conn, $query);
    if (!$result) {
        echo "2";
        return false;
    }
    if (mysqli_num_rows($result) > 0) {
        // Wpisy istnieją, wykonaj zapytanie UPDATE
        $query = "UPDATE service_realisations SET technican_name = '" . $technican_data['first_name'] . "', technican_last_name = '" . $technican_data['last_name'] . "', technican_phone = '" . $technican_data['phone_number'] . "', date_realised = '" . $date_realised . "', description = '" . $realisation_description . "' WHERE request_id = " . $request_id;
        $result = mysqli_query($conn, $query);
        if ($result) {
            if ($_SESSION['role'] == 'admin') {
                header("Location: /adminPanelServiceData.php?message=succes");
            } elseif ($_SESSION['role'] == 'tech') {
                header("Location: /techPanel.php?message=succes");
            } else {
                header("Location: /index.php");
            }
        } else {
            if ($_SESSION['role'] == 'admin') {
                header("Location: /adminPanelServiceData.php?message=error");
            } elseif ($_SESSION['role'] == 'tech') {
                header("Location: /techPanel.php?message=error");
            } else {
                header("Location: /index.php");
            }
        }
    }

    else {
        // Wpisy nie istnieją, wykonaj zapytanie INSERT
        $query = "INSERT INTO service_realisations (technican_name, technican_last_name, technican_phone, request_id, date_realised, description) 
            VALUES ('" . $technican_data['first_name'] . "', '" . $technican_data['last_name'] . "', '" . $technican_data['phone_number'] . "', " . $request_id . ", '" . $date_realised . "', '" . $realisation_description . "')";
        $result = mysqli_query($conn, $query);
            if($result){
                if($_SESSION['role'] == 'admin'){
                    header("Location: /adminPanelServiceData.php?message=succes");
                }elseif ($_SESSION['role'] == 'tech'){
                    header("Location: /techPanelServiceData.php?message=succes");
                }else{
                    header("Location: /index.php");
                }
            } else {
                if($_SESSION['role'] == 'admin'){
                    header("Location: /adminPanelServiceData.php?message=error");
                }elseif ($_SESSION['role'] == 'tech'){
                    header("Location: /techPanelServiceData.php?message=error");
                }else{
                    header("Location: /index.php");
                }
            }

        }



}
