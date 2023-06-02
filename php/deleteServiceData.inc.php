<?php
session_start();

$request_id_data = $_GET['request_id_data'];
$request_id_realisation = $_GET['request_id_realisation'];
if (isset($_SESSION["userid"]) && $_SESSION["role"] === "admin") {
    include_once 'dbHandler.inc.php';
    include_once 'functions.inc.php';

    // Wykonaj operację usuwania zgłoszenia serwisowego o podanym identyfikatorze
    $result = deleteServiceRequest($conn, $request_id_data, $request_id_realisation);

    if ($result) {
        header("Location: /adminPanelServiceData.php?success=requestdeleted");
    } else {
        header("Location: /adminPanelServiceData.php?error=requestdeletefailed?request_id_data=$request_id_data&request_id_realisation=$request_id_realisation");
    }
} else {
    header("Location: /index.php");
}
exit();
