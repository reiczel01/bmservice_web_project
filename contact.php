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
        <div class="row" style="margin-top: 3em; margin-bottom: 3em;">
            <div class="col-4 contact-info">
                <h3>Dane kontaktowe:</h3>
                <br>
                <H4><strong>Biuro:</strong></H4>
                <p>ul. Starowa 22 92-374 Łóóź</p>
                <p>NIP: 725 111 55 56</p>
                <p>tel. +48 598 235 458</p>
                <p>e-mail: biuro@bmservice.com</p>
                <br><br>
                <h4><strong>Serwis:</strong></h4>
                <br>
                <p><strong>Marcin Gambora - Kierownik serwisu</strong></p>
                <p>tel. +48 456 879 546</p>
                <p>e-mail: gambora@bmservice.com</p>
                <br>
                <p><strong>Obsługa klienta:</strong></p>
                <p>tel. +48 357 159 456</p>
                <p>e-mail: serwis@bmserwis.com</p>

            </div>
            <div class="col-8 map">
                <iframe class="rounded-corners" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2471.563250798995!2d19.47148567659518!3d51.722732471863075!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x471a3488c7688285%3A0xa1ac56170f962b2d!2zS29uZ3Jlc293YSwgOTAtMDAxIMWBw7Nkxbo!5e0!3m2!1sen!2spl!4v1684581927082!5m2!1sen!2spl" width="100%" height="100%" style="border: none;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
        <div class="row">
            <div class="col-2">
                <br>
            </div>
            <div class="col-8 formBackground map">
                <form class="form" id="contsctForm" action="php/formMailSender.php" method="post">
                    <h1 class="formTitle">Skontaktuj się z nami:</h1>
                    <div class="tab">
                        <div class="field">
                            <span class="material-symbols-outlined">signature</span>
                            <input type="text" class="input-field" placeholder="Imie" id="name" name="name" required>
                            <span class="material-symbols-outlined">horizontal_distribute</span>
                            <input type="text" class="input-field" placeholder="Nazwisko" id="surname" name="surname" required>
                        </div>
                        <div class="field">
                            <span class="material-symbols-outlined">alternate_email</span>
                            <input placeholder="E-mail" class="input-field" required>
                        </div>
                        <div class="field">
                            <span class="material-symbols-outlined">call</span>
                            <input placeholder="Telefon" class="input-field" required>
                        </div>
                        <h3 class="formTitle">Wiadomość:</h3>
                        <div class="field">
                            <!--<span class="material-symbols-outlined">description</span>-->
                            <textarea id="message" name="message" class="input-field" rows="5" placeholder=" Wprowadź swoją wiadomość" required></textarea>
                        </div>
                    </div>
                    <div class="btn">
                        <button class="button1" type="submit" name="carRegistration-submit">Wyślij</button>
                    </div>
                </form>
            </div>
            <div class="col-2">
                <br>
            </div>
        </div>
    </div>
</div>

</body>
<script type="text/javascript" src="js/nav.js"></script>
</html>
