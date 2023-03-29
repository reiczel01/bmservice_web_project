<style type="text/css">;
    @import url("scss/top-bar.css");
    @import url("https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0");
</style>
<div class="top-bar">
    <object class="logo-top" data="images/logo/logo-main.svg" width="300" height="85"> </object>
    <div class="user-icon">


        <?php
        session_start();
        if ($_SESSION["useris_admin"] == 1) {
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
