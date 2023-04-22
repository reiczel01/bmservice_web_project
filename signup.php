<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="style.css">
    <title>Moja pierwsza strona</title>
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
            <div class="col-2" id="cont"></div>
            <div class="col-8">
                <form class="form" action="/php/signup.inc.php" id="login" method="post">
                    <p id="heading">Sign Up</p>
                    <div class="field">
                        <span class="material-symbols-outlined">badge</span>
                        <input autocomplete="off" placeholder="Username" class="input-field" type="text" name="username">
                    </div>
                    <div class="field">
                        <span class="material-symbols-outlined">badge</span>
                        <input autocomplete="off" placeholder="E-mail" class="input-field" type="text" name="email">
                    </div>
                    <div class="field">
                        <span class="material-symbols-outlined">password</span>
                        <input placeholder="Password" class="input-field" type="password" name="password">
                    </div>
                    <div class="field">
                        <span class="material-symbols-outlined">password</span>
                        <input placeholder="Re-enter password" class="input-field" type="password" name="passwordRepeat">
                    </div>
                    <div class="btn">
                        <button class="button1" type="submit" name="signup_btn">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Login&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</button>
                    </div>
                </form>
            </div>
        </div>
</body>
    <?php
    if(!empty($_SESSION["userid"]))
    {
        header("Location: index.php?error=alreadyLoggedIn");
    }
    include 'php/notification.inc.php';
    if (isset($_GET["error"])) {
        //notification($_GET["error"]);
    }

