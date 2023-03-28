
<style>;
	@import url("scss/login.css");
	@import url("https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0");
</style>

<div class="container">
    <div class="row">
        <div class="col" id="cont"></div>
        <div class="col">
            <form class="form" action="php/login.inc.php" id="login" method="post">
              <p id="heading">Login</p>
              <div class="field">
                <span class="material-symbols-outlined">badge</span>
                <input autocomplete="off" placeholder="Username/email" class="input-field" type="text" name="username">
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

            <form class="form" id="success" method="post" style="display: none;">
              <p id="heading">Zalogowano pomyślnie</p>
              <div>
                <span class="material-symbols-outlined logout" style="font-size: 80px; color: yellowgreen;">check_circle</span>
              </div>
                <div>
                    <br>
                </div>

            </form>

        </div>
        <div class="col">
            <form class="form" id="logout" method="post" style="display: none;">
                <p id="heading">Chcesz się wylogować?</p>
                <div>
                    <button class="material-symbols-outlined" style="
                    font-size: 80px;
                    color: yellowgreen;
                    background-color: transparent;
                    border: none;
                    outline: none;">logout</button>
                </div>
                <div>
                    <br>
                </div>

            </form>
        </div>
    </div>
</div>
<script>
    document.querySelector('#login').style.display = '';
    document.querySelector('#success').style.display = '';
    document.querySelector('#logout').style.display = '';
    document.querySelector('#cont').style.display = 'none';
</script>

<!--meni edycji rezerwacji: https://codepen.io/havardob/pen/YzwzQgm-->
