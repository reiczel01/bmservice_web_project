<?php
session_start();
if (isset($_SESSION["userid"])) {
    include_once 'dbHandler.inc.php';
    include_once 'functions.inc.php';
    $user_id = $_SESSION["userid"];

    $serviceData = createTwoDimensionalArrayOfServiceRequests($conn, $user_id);

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
        echo '
<div class="row" style="margin: 0 0; border-bottom: 1px solid #ccc;"></div>
<div class="row" style="margin-top: 3em; margin-bottom: 3em;">
        <div class="col-4">
            <h3>Samochód:</h3>
            <p><strong>model:</strong> '.$service["model"].'</p>
            <p><strong>silnik:</strong> '.$service["make"].'</p>
            <p><strong>rejestracja:</strong> '.$service["registration_nr"].'</p>
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
            <br>
            <p><strong>opis usterki</strong><br> '.$service["request_description"].'</p>
            <br>
            <p><strong>wykonane prace:</strong><br> '.$service["realisation_description"].'</p>
        </div>
</div>
<div class="row" style="margin: 0 0; border-bottom: 1px solid #ccc;"></div>

        ';
    }
} else {
    exit;
}
