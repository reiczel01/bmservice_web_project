<style type="text/css">;
    @import url("scss/top-bar.css");
    @import url("css/notification.css");
    @import url("https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0");
</style>
<div class="top-bar">
    <a href="/index.php"><object class="logo-top" data="images/logo/logo-main.svg" width="300" height="85"></object></a>
    <div class="user-icon">


        <?php
        session_start();
        include "php/notification.inc.php";
        //notification($_GET["error"]);
        if (strcasecmp($_SESSION["role"], "admin") === 0) {
            echo '<a href="#" class="material-symbols-outlined">auto_fix</a>';
            echo '<a href="#" class="material-symbols-outlined">account_circle</a>';
        }
        else
        {
            if(isset($_SESSION["userid"]))
            {
                echo '<a href="#" class="material-symbols-outlined">account_circle</a>';
            }
        }
        ?>
    </div>
</div>
