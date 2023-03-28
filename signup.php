<style>;
    @import url("scss/login.css");
    @import url("https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0");
</style>

<div class="container">
    <div class="row">
        <div class="col" id="cont"></div>
        <div class="col">
            <form class="form" action="php/signup.inc.php" id="login" method="post">
                <p id="heading">Sign Up</p>
                <div class="field">
                    <span class="material-symbols-outlined">badge</span>
                    <input autocomplete="off" placeholder="Name" class="input-field" type="text" name="name">
                </div>
                <div class="field">
                    <span class="material-symbols-outlined">badge</span>
                    <input autocomplete="off" placeholder="Surname" class="input-field" type="text" name="surname">
                </div>
                <div class="field">
                    <span class="material-symbols-outlined">badge</span>
                    <input autocomplete="off" placeholder="Username" class="input-field" type="text" name="username">
                </div>
                <div class="field">
                    <span class="material-symbols-outlined">badge</span>
                    <input autocomplete="off" placeholder="E-mail" class="input-field" type="text" name="email">
                </div>
                <div class="field">
                    <span class="material-symbols-outlined">badge</span>
                    <input autocomplete="off" placeholder="Phone" class="input-field" type="text" name="phone">
                </div>

                <div class="field">
                    <span class="material-symbols-outlined">badge</span>
                    <input autocomplete="off" placeholder="Address" class="input-field" type="text" name="address">
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
    <?php
    include 'php/notification.inc.php';
    if (isset($_GET["error"])) {
        notification($_GET["error"]);
    }

