<?php
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
        echo "       document.querySelector('#success').style.display = 'block';";
        echo "       window.location.href = '/login.php';";
        echo "   </script>";
        exit;
    } else {
        // logowanie nieudane
        echo "Invalid username or password";
    }

    $conn->close();
}
?>
