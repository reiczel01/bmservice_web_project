<?php
session_start();
if(isset($_SESSION["userid"])) {
    include_once 'dbHandler.inc.php';
    include_once 'functions.inc.php';
    $user_id = $_SESSION["userid"];

    $serviceData = createTwoDimensionalArrayOfServiceRequests($conn, $user_id);
    debug_to_console($serviceData);
    foreach ($serviceData as $service) {
        echo '
            <div class="row">
                <div class="col">
                    <h3>Samochód:</h3>
                    <p>model: '.$service["model"].'</p>
                    <p>silnik: '.$service["make"].'</p>
                    <p>rejestracja: '.$service["registration_nr"].'</p>
                </div>
                <div class="col">
                    <h3>Zgłoszenie serwisowe:</h3>
                    <p>data zgłoszenia: '.$service["date_requested"].'</p>
                    <p>data realizacji: '.$service["date_realised"].'</p>
                    <p>przebieg: '.$service["milage"].'</p>
                </div>
                <div class="col">
                    <br>
                    <p>opis usterki: '.$service["sr.description"].'</p>
                    <p>wykonane prace: '.$service["srr.description"].'</p>
                </div>
                <div class="col">
                    <h3>Technik:</h3>
                    <p>Imie: '.$service["technican_name"].'</p>
                    <p>Nazwisko: '.$service["technican_last_name"].'</p>
                    <p>Telefon: '.$service["technican_phone"].'</p>
                </div>
            </div>
            <div class="row">
            <br>
            </div>
        ';
    }
} else {
    exit;
}
