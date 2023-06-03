<?php
session_start();
if(!isset($_SESSION['userid']) && $_SESSION['userType'] != 'tech'){
    header("Location: /index.php");
    exit();
}
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Panel Mechanika</title>
    <link rel="stylesheet" href="/css/bootstrap-impostor.css">
    <style type="text/css">
        @import url("css/car.css");
        @import url("css/serviceHistory.css")
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
        <input type="text" id="search" onkeyup="searchFunction()" placeholder="Wyszukaj na stronie...">

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


        <?php
        include('php/displayServiceDataTech.inc.php');
        ?>
    </div>
</div>


</body>
<script type="text/javascript" src="js/nav.js"></script>
</html>