<?php
session_start();
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Moja pierwsza strona</title>
    <link rel="stylesheet" href="/css/bootstrap-impostor.css">
    <style type="text/css">
        @import url("css/data-table.css");
        @import url("css/car.css");
        @import url("scss/nav.css");
        @import url("scss/top-bar.css");
        @import url("scss/content.css");
        @import url("https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0");
    </style>
</head>

<body>
<?php
include('top-bar.php');
include('nav.php');
?>
<div class="content" style="background: #2b343b; border-left: 10px solid #FFFFFF00; border-right: 10px solid #FFFFFF00;">
    <div class="container">
        <div class="row">
            <div class="col-2" style="display: flex; justify-content: center;">
            </div>
            <div class="col-8">
                <form class="form" id="carRegistration" action="/php/userData.inc.php" method="post">
                    <h3 class="formTitle">Rejestracja danych:</h3>
                    <div class="tab">
                        <div class="field">
                            <span class="material-symbols-outlined">person</span>
                            <input placeholder="Imie" name="first_name" class="input-field" required>
                        </div>
                        <div class="field">
                            <span class="material-symbols-outlined">person</span>
                            <input placeholder="Nazwisko" name="last_name" class="input-field" required>
                        </div>
                        <div class="field">
                            <span class="material-symbols-outlined">apartment</span>
                            <input placeholder="Nazwa firmy" name="company_name" class="input-field">
                        </div>
                        <div class="field">
                            <span class="material-symbols-outlined">pin</span>
                            <input placeholder="NIP / EU VAT" name="vat_id" class="input-field">
                        </div>
                        <div class="field">
                            <span class="material-symbols-outlined">add_location</span>
                            <input placeholder="Adres" name="address" class="input-field" required>
                        </div>
                        <div class="field">
                            <span class="material-symbols-outlined">call</span>
                            <input placeholder="Telefon" name="phone_number" class="input-field" required>
                        </div>
                    </div>
                    <div class="btn">
                        <button class="button1" type="submit" name="carRegistration-submit">Zarejestruj</button>
                    </div>
                </form>
            </div>
            <div class="col-2" style="display: flex; justify-content: center;">
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <?php
                include 'php/userDataTableCreate.inc.php';
                ?>
            </div>
        </div>
    </div>
</div>


</body>
<script type="text/javascript" src="js/nav.js"></script>
</html>