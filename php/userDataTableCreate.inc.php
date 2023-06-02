<?php
session_start();
if (isset($_SESSION["userid"])) {
    include_once 'dbHandler.inc.php';
    include_once 'functions.inc.php';
    $user_id = $_SESSION["userid"];
    // Pobranie danych z bazy danych
    $userData = getUserData($conn, $user_id);
    // Przejście przez dane i wypełnienie tabeli
    echo '
        <link rel="stylesheet" type="text/css" href="../css/data-table.css">
        <style>
            table {
                width: 100%;
                border-collapse: collapse;
            }
            th, td {
                padding: 8px;
                word-wrap: break-word;
            }
        </style>

        <table>
            <thead>
                <tr>
                    <th>Imie</th>
                    <th>Nazwisko</th>
                    <th>Nazwa firmy</th>
                    <th>NIP / EU VAT</th>
                    <th>Adres</th>
                    <th>Telefon</th>
                </tr>
            </thead>
            <tbody>';
    foreach ($userData as $data) {
        echo '<tr>
              <td>'.$data["first_name"].'</td>
              <td>'.$data["last_name"].'</td>
              <td>'.($data["company_name"] ? $data["company_name"] : "Nie dotyczy").'</td>
              <td>'.($data["vat_id"] ? $data["vat_id"] : "Nie dotyczy").'</td>
              <td>'.$data["address"].'</td>
              <td>'.$data["phone_number"].'</td>
          </tr>';
    }

    echo '</tbody></table>';
} else {
    exit;
}
?>
