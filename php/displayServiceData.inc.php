<?php
session_start();
echo '    <link rel="stylesheet" href="/scss/btn.css">';
if (isset($_SESSION["userid"]) && $_SESSION["role"] === "admin") {
    include_once 'dbHandler.inc.php';
    include_once 'functions.inc.php';
    $user_id = $_SESSION["userid"];

    $serviceData = getServiceData($conn);

    foreach ($serviceData as $service) {
        if ($service["realisation_description"] == null) {
            $service["realisation_description"] = "brak";
        }
        if ($service["date_realised"] == null) {
            $service["date_realised"] = "brak";
        }
        if ($service["technican_name"] == null || $service["technican_last_name"] == null || $service["technican_phone"] == null) {
            $service["technican_name"] = "nie przypisano";
            $service["technican_last_name"] = "nie przypisano";
            $service["technican_phone"] = "nie przypisano";
        }
        $carData = getCarDataById($conn, $service['car_id']);
        $billingData = getFirstRecord($conn, $service['data_id']);
        echo '
<div class="row" style="margin: 0 0; border-bottom: 1px solid #ccc;"></div>
<div class="row rq" style="margin-top: 3em; margin-bottom: 3em;">
        <div class="col-4">
            <h3>Samochód:</h3>
            <p><strong>model:</strong> '.$carData["model"].'</p>
            <p><strong>silnik:</strong> '.$carData["make"].'</p>
            <p><strong>rejestracja:</strong> '.$carData["registration_nr"].'</p>
            <p><strong>rok produkcji:</strong> '.$carData["production_year"].'</p>
            <p><strong>vin:</strong> '.$carData["vin"].'</p>
            <br>
            <h3>Zgłoszenie serwisowe:</h3>
            <p><strong>data zgłoszenia:</strong> '.$service["date_requested"].'</p>
            <p><strong>data realizacji:</strong> '.$service["date_realised"].'</p>
            <p><strong>przebieg:</strong> '.$service["milage"].' KM</p>
            <br>
            <h3>Technik:</h3>
            <p><strong>Imie:</strong> '.$service["technican_name"].'</p>
            <p><strong>Nazwisko:</strong> '.$service["technican_last_name"].'</p>
            <p><strong>Telefon:</strong> '.$service["technican_phone"].'</p>
        </div>
        <div class="col-8">
            <h3>Dane do faktury:</h3>        
            <p><strong>Imie:</strong> '.$billingData["first_name"].'</p>            
            <p><strong>Nazwisko:</strong> '.$billingData["last_name"].'</p>            
            <p><strong>Firma:</strong> '.$billingData["company_name"].'</p>            
            <p><strong>NIP:</strong> '.$billingData["vat_id"].'</p>            
            
            <p><strong>Telefon:</strong> '.$billingData["phone_number"].'</p>
            <br>
            <p><strong>Opis usterki:</strong><br> '.$service["request_description"].'</p>
            <br>
            <p><strong>Wykonane prace:</strong><br> '.$service["realisation_description"].'</p>
            <br>
            <a href="../adminServiceDataEdit.php?request_id_data='.$service["request_id_data"].'&request_id_realisation='.$service["realisation_id"].'&realisation_date='.$service["date_realised"].'" class="btn"> <span class="material-symbols-outlined">edit</span></a>
            <a href="php/deleteServiceData.inc.php?request_id_data='.$service["request_id_data"].'&request_id_realisation='.$service["request_id_realisation"].'" class="btn-danger"><span class="material-symbols-outlined">delete_forever</span></a>
        </div>
</div>
<div class="row" style="margin: 0 0; border-bottom: 1px solid #ccc;"></div>

        ';
    }
} else {
    exit;
}

