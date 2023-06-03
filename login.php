<?php
session_start();
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="style.css">
    <title>Zaloguj</title>
    <link rel="stylesheet" href="/css/bootstrap-impostor.css">
    <style type="text/css">
        @import url(scss/nav.css);
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
?>
<div class="content" style="background: none; border-left: 10px solid #FFFFFF00; border-right: 10px solid #FFFFFF00;">
    <div class="container">
        <div class="row">
            <div class="col" id="cont"></div>
            <div class="col">
                <?php
                if (!isset($_SESSION['userid'])) {
                    echo '
                <form class="form" action="/php/login.inc.php" id="login" method="post" style="padding-bottom: 40px">
                    <p id="heading">Login</p>
                    <div class="field">
                        <span class="material-symbols-outlined">badge</span>
                        <input autocomplete="off" placeholder="Username/email" class="input-field" type="text" name="username">
                    </div>
                    <div class="field">
                        <span class="material-symbols-outlined">password</span>
                        <input placeholder="Password" class="input-field" type="password" name="password">
                    </div>
                    <div class="btn">
                        <button class="button1" type="submit" name="login_btn">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Zaloguj się&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</button>
                        <button class="button1" name="signup_btn">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Zarejestruj&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</button>
                    </div>
                
                </form>';
                } else {
                    echo '
                <form class="form" id="login">
                    <p id="heading">Udało ci się zalogować!</p>
                    <br>
                    <span class="material-symbols-outlined" style="font-size: 120px; color: green;">check_circle</span>
                    <div class="btn">
                        <br>
                        <br>
                    </div>
                </form>';
                }
                ?>
            </div>
            <div class="col"></div>
</div>
</body>
<script>
    document.querySelector('#login').style.display = '';
    document.querySelector('#success').style.display = '';
    document.querySelector('#logout').style.display = '';
    document.querySelector('#cont').style.display = 'none';
</script>
<?php
include 'php/notification.inc.php';
if (isset($_GET["error"])) {
    notification($_GET["error"]);
}
exit();

