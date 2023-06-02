<?php

if(isset($_POST["carRegistration-submit"])) {
    $model = $_POST["model"];
    $engineDesignation = $_POST["engineDesignation"];
    $year = $_POST["year"];
    $carRegistration = $_POST["carRegistration"];
    $vin = $_POST["vin"];
    require_once 'dbHandler.inc.php';
    require_once 'functions.inc.php';

    checkSession();

    if(isUserLoggedIn()){
        header("Location: /cars.php?error=notloggedin");
        exit();
    }

    if(emptyInputCar($carRegistration, $vin, $engineDesignation, $model, $year)) {
        header("Location: /cars.php?error=emptyinput");
        exit();
    }

    if(carRegistrationCheck($carRegistration)) {
        header("Location: /cars.php?error=invalidcarregistration");
        exit();
    }

    if(carVinCheck($vin)) {
        header("Location: /cars.php?error=invalidvin");
        echo("empty input");
        exit();
    }

    if(!yearCheck($year)) {
        header("Location: /cars.php?error=invalidyear");
        exit();
    }

    if(carExists($conn, $carRegistration)) {
        header("Location: /cars.php?error=carexists");
        exit();
    }

    registerCar($conn, $_SESSION["userid"], $engineDesignation, $model, $carRegistration, $vin, $year);
}

