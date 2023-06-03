<?php
session_start();
if(!isset($_SESSION['userid'])){
    header("Location: /index.php");
    exit();
}
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Panel Administracyjny - Samochody</title>
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

        <script>
            function searchFunction() {
                var input, filter, divs, i;
                input = document.getElementById('search');
                filter = input.value.toUpperCase();
                divs = document.getElementsByClassName('rq');

                for (i = 0; i < divs.length; i++) {
                    if (divs[i].textContent.toUpperCase().indexOf(filter) > -1) {
                        divs[i].style.display = "";
                    } else {
                        divs[i].style.display = "none";
                    }
                }
            }
        </script>
        <table class="product-display-table">
            <thead>
            <tr>
                <th>ID urzytkownika</th>
                <th>Silnik</th>
                <th>Model</th>
                <th>VIN</th>
                <th>Nr rejestracyjny</th>
                <th>Data produkcji</th>
                <th>Akcja<br><input type="text" id="search" onkeyup="searchFunction()" placeholder="Wyszukaj na stronie...">
                </th>
            </tr>
            </thead>
            <?php
            include('php/displayCarsData.inc.php');
            ?>

        </table>
    </div>
</div>
