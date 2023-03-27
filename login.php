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
	
	<div class="top-bar">
			<object class="logo-top" data="images/logo/logo-main.svg" width="300" height="85"> </object>
			<div class="user-icon"><a href="#" class="material-symbols-outlined">account_circle</a></div>
	</div>
	
	<div class="navigation">
	  <ul>
		<li class="list"> <a href="/index.html"> <span class="icon"><i class="material-symbols-outlined"> home </i></span> <span class="title">Home</span> </a> </li>
		<li class="list"> <a href="#"> <span class="icon"><i class="material-symbols-outlined"> description </i></span> <span class="title">O nas</span> </a> </li>
		<li class="list"> <a href="#"> <span class="icon"><i class="material-symbols-outlined"> build </i></span> <span class="title">Serwis</span> </a> </li>
		<li class="list"> <a href="#"> <span class="icon"><i class="material-symbols-outlined"> event </i></span> <span class="title">Terminarz</span> </a> </li>
		<li class="list"> <a href="#"> <span class="icon"><i class="material-symbols-outlined"> manage_history </i></span> <span class="title">Historia napraw</span> </a> </li>
		<li class="list"> <a href="#"> <span class="icon"><i class="material-symbols-outlined"> contact_page </i></span> <span class="title">Kontakt</span> </a> </li>
		<li class="list active"> <a href="login.php"> <span class="icon"><i class="material-symbols-outlined"> login </i></span> <span class="title">Login</span> </a> </li>
	  </ul>
	</div>
	
	<div class="content" style="background: none; border-left: 10px solid #FFFFFF00; border-right: 10px solid #FFFFFF00;">
		<div class="container">
			<div class="row">
				<div class="col"></div>
				<div class="col">
					<form class="form" id="login" method="post">
					  <p id="heading">Login</p>
					  <div class="field">
						<span class="material-symbols-outlined">badge</span>
						<input autocomplete="off" placeholder="Username" class="input-field" type="text" name="username">
					  </div>
					  <div class="field">
						<span class="material-symbols-outlined">password</span>
						<input placeholder="Password" class="input-field" type="password" name="password">
					  </div>
					  <div class="btn">
						<button class="button1" type="submit" name="login_btn">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Login&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</button>
						<button class="button2">Sign Up</button>
					  </div>
					  <button class="button3">Forgot Password</button>
					</form>
					
					<form class="form" id="succes" method="post" style="display:;">
					  <p id="heading">Succesfuly loged in</p>
					  <div>
						<span class="material-symbols-outlined" style="font-size: 80px; color: yellowgreen;">check_circle</span>
					  </div>
						<div></div>
						
					</form>

				</div>
				<div class="col" ></div>
			</div>
		</div>
	</div>
<?php
echo "<script>";
echo "       document.querySelector('#login').style.display = '';";
echo "       document.querySelector('#succes').style.display = 'none';";         
echo "   </script>";		
if (isset($_POST['login_btn'])) {
    // pobranie danych z formularza
    $username = $_POST['username'];
    $password = $_POST['password'];

    // połączenie z bazą danych
    $servername = "db_web:3306";
    $username_db = "root";
    $password_db = "my-new-password";
    $dbname = "mbservice";

    $conn = new mysqli($servername, $username_db, $password_db, $dbname);

    // sprawdzenie połączenia
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
	
	

    // zapytanie SQL do bazy danych
    $sql = "SELECT * FROM users WHERE username='$username' AND password=AES_ENCRYPT('$password', 'klucz_szyfrowania')";
    $result = $conn->query($sql);

    // sprawdzenie czy użytkownik istnieje
    if ($result->num_rows > 0) {
        // logowanie udane
        session_start();
        $_SESSION['username'] = $username;
       
        echo "<script>";
        echo "       document.querySelector('#login').style.display = 'none';";
        echo "       document.querySelector('#succes').style.display = '';";
            
        echo "   </script>";
        exit;
    } else {
        // logowanie nieudane
        echo "Invalid username or password";
    }

    $conn->close();
}
?>	
</body>
<script type="text/javascript" src="js/nav.js"></script>
</html>
<!--meni edycji rezerwacji: https://codepen.io/havardob/pen/YzwzQgm-->
