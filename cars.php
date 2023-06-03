<?php
session_start();
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Moje pojazdy</title>
    <link rel="stylesheet" href="/css/bootstrap-impostor.css">
    <style type="text/css">
        @import url("css/data-table.css");
        @import url("css/car.css");
        @import url("scss/nav.css");
        @import url("scss/top-bar.css");
        @import url("scss/content.css");
        @import url("scss/login.css");

        @import url("https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0");
    </style>
</head>

<body>
<?php
include('top-bar.php');
include('nav.php');
if(isset($_SESSION['userid'])) {
    echo '
    <div class="content" style="background: #2b343b; border-left: 10px solid #FFFFFF00; border-right: 10px solid #FFFFFF00;">
    <div class="container">
        <div class="row">
            <div class="col-4">
                <form class="form" id="carRegistration" action="/php/service.inc.php" method="post">
                    <h3 class="formTitle">Rejestracja pojazdu:</h3>
                    <div class="tab">
                        <div class="field">
                            <span class="material-symbols-outlined">directions_car</span>
                            <input placeholder="Model" name="model" class="input-field">
                        </div>
                        <div class="field">
                            <span class="material-symbols-outlined">settings</span>
                            <input placeholder="Oznaczenie silnika" name="engineDesignation" class="input-field">
                        </div>
                        <div class="field">
                            <span class="material-symbols-outlined">event_available</span>
                            <input placeholder="Rocznik produkcyjny" name="year" class="input-field">
                        </div>
                        <div class="field">
                            <span class="material-symbols-outlined">pin</span>
                            <input placeholder="Rejestracja" name="carRegistration" class="input-field">
                        </div>
                        <div class="field">
                            <span class="material-symbols-outlined">password</span>
                            <input placeholder="VIN" name="vin" class="input-field">
                        </div>
                    </div>
                    <div class="btn">
                        <button class="button1" type="submit" name="carRegistration-submit">Zarejestruj</button>
                    </div>
                </form>
            </div>
            <div class="col-8" style="display: flex; justify-content: center;">';
    include 'php/carTableCreate.inc.php';
    echo '
            </div>
        </div>
    </div>';
}else {
    echo '
                <form class="form" id="login">
                    <h1 id="heading" style="color: white;">ZALOGUJ SIĘ!</h1>
                    <br>
                    <span class="material-symbols-outlined" style="font-size: 120px; color: red;">cancel</span>
                    <div class="btn">
                        <br>
                        <br>
                    </div>
                </form>';
}
?>






</body>
<script type="text/javascript" src="js/nav.js"></script>
</html>