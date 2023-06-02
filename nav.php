<style type="text/css">
    @import url(scss/nav.css);
    @import url("https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0");
</style>
<div class="navigation">
    <ul>
        <li class="list"> <a href="/index.php"> <span class="icon"><i class="material-symbols-outlined"> home </i></span> <span class="title">Home</span> </a> </li>
        <li class="list"> <a href="/userData.php"> <span class="icon"><i class="material-symbols-outlined"> description </i></span> <span class="title">Twoje dane</span> </a> </li>
        <li class="list"> <a href="/cars.php"> <span class="icon"><i class="material-symbols-outlined"> directions_car </i></span> <span class="title">Pojazdy</span> </a> </li>
        <li class="list"> <a href="/timetable.php"> <span class="icon"><i class="material-symbols-outlined"> build_circle </i></span> <span class="title">Zgłoś</span> </a> </li>
        <li class="list"> <a href="/serviceHistory.php"> <span class="icon"><i class="material-symbols-outlined"> manage_history </i></span> <span class="title">Zgłoszenia</span> </a> </li>
        <li class="list"> <a href="/contact.php"> <span class="icon"><i class="material-symbols-outlined"> contact_page </i></span> <span class="title">Kontakt</span> </a> </li>
        <?php
        session_start();
        if (isset($_SESSION["userid"])) {
            echo '<li class="list"> <a href="/php/logout.inc.php?action=logout"> <span class="icon"><i class="material-symbols-outlined"> logout </i></span> <span class="title">Logout</span> </a> </li>';
        }
        else
        {
            echo '<li class="list"> <a href="login.php"> <span class="icon"><i class="material-symbols-outlined"> login </i></span> <span class="title">Login</span> </a> </li>';
        }
        ?>

    </ul>
</div>
<script type="text/javascript" src="js/nav.js"></script>
