<?php
session_start();
?>
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
<div class="content" style="background: #2b343b; border-left: 10px solid #FFFFFF00; border-right: 10px solid #FFFFFF00;">
    <div class="container">
        <div class="row" style="margin-top: 3em; margin-bottom: 3em;">
            <div class="col-5">
                <h3>Dane kontaktowe:</h3>
                <br>
                <H4><strong>Biuro:</strong></H4>
                <pre><code>
ul.   Anstafa 32
       Łódź 92-345
kraj: Polska
Tel:  +48 123 456 178
                </code></pre>
                <br>
            </div>
            <div class="col-7">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2471.563250798995!2d19.47148567659518!3d51.722732471863075!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x471a3488c7688285%3A0xa1ac56170f962b2d!2zS29uZ3Jlc293YSwgOTAtMDAxIMWBw7Nkxbo!5e0!3m2!1sen!2spl!4v1684581927082!5m2!1sen!2spl" style="border:5em;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </div>
</div>

</body>
<script type="text/javascript" src="js/nav.js"></script>
</html>
