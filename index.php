<?php
session_start();
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<link rel="stylesheet" href="style.css">
<title>BMSERVICE</title>
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
    <div class="content" style="background: #2b343b; border-left: 10px solid #FFFFFF00; border-right: 10px solid #FFFFFF00;">
        <div class="container">
            <div class="row">
                <div class="col-12">
    <h1>Menu - Readme</h1>
    <h2>Opis działania platformy</h2>
    <p>Wykonanie pierwszych kroków:</p>
    <h3>1. Dodawanie danych</h3>
    <p>Przed rozpoczęciem korzystania z menu, należy dodać swoje dane osobowe. W tym celu kliknij na zakładkę "Twoje dane" i wypełnij formularz, podając wymagane informacje, takie jak imię, nazwisko, adres, numer telefonu itp.</p>
    <h3>2. Rejestracja pojazdu</h3>
    <p>Po dodaniu danych osobowych, możesz przejść do rejestracji pojazdu. Wybierz zakładkę "Pojazdy" i podaj potrzebne informacje o swoim pojeździe, takie jak marka, model, rok produkcji, numer rejestracyjny itp.</p>
    <h3>3. Tworzenie zgłoszenia serwisowego</h3>
    <p>Po zarejestrowaniu pojazdu, będziesz mógł tworzyć zgłoszenia serwisowe. Przejdź do zakładki "Zgłoś" i kliknij na przycisk "Nowe zgłoszenie". Wypełnij formularz zgłoszenia, podając szczegóły problemu, który napotkałeś. Po zakończeniu, zgłoszenie zostanie dodane do listy zgłoszeń serwisowych.</p>
    <h3>Przeglądanie zgłoszeń serwisowych</h3>
    <p>W zakładce "Zgłoszenia" możesz przeglądać listę wszystkich zgłoszeń serwisowych. Znajdziesz tam informacje o zgłoszeniach, takie jak numer zgłoszenia, data utworzenia, opis problemu itp. Możesz także wyszukiwać zgłoszenia według określonych kryteriów, takich jak status zgłoszenia, data utworzenia itp.</p>
    <h2>Uwagi</h2>
    <p>Przed korzystaniem z menu upewnij się, że masz aktywne połączenie internetowe oraz przeglądarkę obsługującą technologię HTML5.</p>
</div>
        </div>
    </div>
    </div>
</div>

</body>
<script type="text/javascript" src="js/nav.js"></script>
</html>
