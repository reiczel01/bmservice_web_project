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
    <?php
    include('login.php');
    include('signup.php');
    ?>
</div>


</body>
<script type="text/javascript" src="js/nav.js"></script>
</html>
<!--meni edycji rezerwacji: https://codepen.io/havardob/pen/YzwzQgm-->
