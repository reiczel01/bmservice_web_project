<?php
session_start();

$car_id = $_GET['car_id'];
if (isset($_SESSION["userid"]) && $_SESSION["role"] === "admin") {
    include_once 'dbHandler.inc.php';
    include_once 'functions.inc.php';
    var_dump($car_id);
    // Wykonaj operację usuwania samochodu o podanym identyfikatorze
    $result = deleteCar($conn, $car_id);

    if ($result) {
        header("Location: /adminPanelCarData.php?success=cardeleted");
    } else {
        header("Location: /adminPanelCarData.php?error=cardeletefailed");
    }
} else {
    header("Location: /index.php");
}
exit();
