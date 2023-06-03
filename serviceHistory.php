<?php
session_start();

?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Zgłoszenia</title>
    <link rel="stylesheet" href="/css/bootstrap-impostor.css">
    <style type="text/css">
        @import url("css/car.css");
        @import url("css/serviceHistory.css")
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
    echo '<div class="content" style="background: #2b343b; border-left: 10px solid #FFFFFF00; border-right: 10px solid #FFFFFF00;">
    <div class="container">
        <div class="field">
            <input type="text" class="input-field" id="search" onkeyup="searchFunction()" placeholder="Wyszukaj na stronie...">
        </div>';
    include('php/serviceRequestRealizationDisplay.inc.php');
    echo '</div>
</div>
';
    }else{
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
</html>