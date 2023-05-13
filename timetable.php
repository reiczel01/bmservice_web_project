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
            <div class="col-2"></div>
            <div class="col-8">
                <form class="form" id="carRegistration" action="/php/service.inc.php" method="post">
                    <h1 class="formTitle">Zgłoszenie serwisowe:</h1>
                    <div class="tab">
                        <div class="field">
                            <span class="material-symbols-outlined">directions_car</span>
                            <?php
                            include 'php/carSelector.inc.php';
                            ?>
                        </div>
                        <div class="field">
                            <span class="material-symbols-outlined">new_label</span>
                            <input placeholder="Przebieg" class="input-field">
                        </div>
                        <div class="field">
                            <span class="material-symbols-outlined">date_range</span>
                            <input class="input-field" type="date" placeholder="Data przyjęcia" id="start" name="trip-start"
                                   value="2018-07-22"
                                   min="2018-01-01" max="2023-12-31">
                        </div>
                        <h3 class="formTitle">Usterka:</h3>
                        <div class="field">
                            <span class="material-symbols-outlined">description</span>
                            <textarea class="input-field"
                                      rows="2" cols="33">
                            </textarea>
                        </div>
                    </div>
                    <div class="btn">
                        <button class="button1" type="submit" name="carRegistration-submit">Zarejestruj</button>
                    </div>
                </form>
            </div>
            <div class="col-2"></div>
        </div>
    </div>
</div>


</body>
<script type="text/javascript" src="js/nav.js"></script>
</html>