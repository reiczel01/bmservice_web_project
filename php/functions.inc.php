<?php
///////////////////////////////////////////////////////////////////////////////////////////////////////
/// Sekcja funkcji sprawdzających i tworzących nowego urzytkownika                                /////
/// Są one wykonywane z signup.php i signup.inc.php ///////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////

function emptyInputSignup($first_name, $last_name, $username, $email, $phone, $address, $password, $passwordRepeat): bool
{
    if (empty($first_name) || empty($last_name) || empty($username) || empty($email) || empty($phone) || empty($address) || empty($password) || empty($passwordRepeat)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

function invalidUid($username): bool
{

    if (!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

function invalidEmail($email): bool
{
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

function passMatch($password, $passwordRepeat): bool
{
    if ($password !== $passwordRepeat) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

function uidExists($conn, $username, $email) {
    $sql = "SELECT   
  username,
  id,
  password, 
  is_admin, 
  email,
  AES_DECRYPT(first_name, 'klucz_szyfrowania') AS first_name,
  AES_DECRYPT(last_name, 'klucz_szyfrowania') AS last_name,
  AES_DECRYPT(phone, 'klucz_szyfrowania') AS phone,
  AES_DECRYPT(address, 'klucz_szyfrowania') AS address 
  FROM users WHERE username = ? OR email = ?;";
    // inicjaliacja naszego zapytania, ma to za zadanie zabezpieczyć nas przed
    // nadpisaniem danych w naszej bazie przez urzytkownika
    // sql injection
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: ../signup.php?error=stmtfailed");
        exit();
    }

    // przypisanie danych do naszego zapytania
    // (gdzie jest nasze zapytanie, typ danych [string w tym przypadku], dane przekazane przez urzytkownika)
    mysqli_stmt_bind_param($stmt, "ss", $username, $email);
    // wykonanie zapytania
    mysqli_stmt_execute($stmt);

    // pobieranie zanych z naszej bazy po wykonaniu zapytania
    $resultData = mysqli_stmt_get_result($stmt);

    // sprawedzenie czy w naszej bazie istnieje już taki użytkownik
    // zwraca nam dane zapytania a jeśli nie ma to zwraca false
    if ($row = mysqli_fetch_assoc($resultData)) {
        return $row;
    } else {
        return false;
    }

    // zamykamy nasze zapytanie
    mysqli_stmt_close($stmt);
}

function createUser($conn, $first_name, $last_name, $username, $email, $phone, $address, $password, $is_admin): void
{

    $sql = "INSERT INTO users (username, password, is_admin, email, first_name, last_name, phone, address) 
            VALUES (?, ?, ?, ?, AES_ENCRYPT(?, 'klucz_szyfrowania'), AES_ENCRYPT(?, 'klucz_szyfrowania'), AES_ENCRYPT(?, 'klucz_szyfrowania'), AES_ENCRYPT(?, 'klucz_szyfrowania'));";
    // inicjaliacja naszego zapytania, ma to za zadanie zabezpieczyć nas przed
    // nadpisaniem danych w naszej bazie przez urzytkownika
    // sql injection
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: ../signup.php?error=stmtfailed");
        exit();
    }

    // hashowanie hasła
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // przypisanie danych do naszego zapytania
    // (gdzie jest nasze zapytanie, typ danych [string w tym przypadku], dane przekazane przez urzytkownika)
    mysqli_stmt_bind_param($stmt, "ssisssss", $username, $hashedPassword,$is_admin, $email, $first_name, $last_name, $phone, $address);
    // wykonanie zapytania
    mysqli_stmt_execute($stmt);
    // zamykamy nasze zapytanie
    mysqli_stmt_close($stmt);
    header("Location: ../signup.php?error=none");
    exit();
}
///////////////////////////////////////////////////////////////////////////////////////////////////////
/// Sekcja funkcji sprawdzających i logujących istniejącego urzytkownika                          /////
/// Są one wykonywane z signin.php i signin.inc.php ///////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////
function emptyInputLogin($username, $password): bool
{
    if (empty($username) || empty($password)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

function loginUser($conn, $username, $password): void
{
    //sprawdza czy istnieje użytkownik o podanym loginie(email albo username)
    //przy pomocy funkcji uidExists wykorzytywanej również w rejestracji
    $uidExists = uidExists($conn, $username, $username);

    //sprawdzamy czy urzytkownik istnieje
    //jeśli nie to przekierowujemy do strony logowania z błędem
    if ($uidExists === false) {
        header("Location: ../login.php?error=wrongLogin1");
        exit();
    }

    //jeśli urzytkownik istnieje to sprawdzamy czy podane hasło jest poprawne
    //$uidExists["password"] to hasło zapisane w bazie
    $passwordHashed = $uidExists["password"];
    //sprawdzamy czy podane hasło zgadza się z hasłem zapisanym w bazie
    //password_verify zwraca true lub false w zależności od tego czy hasła się zgadzają
    $checkPassword = password_verify($password, $passwordHashed);

    if ($checkPassword === false) {
        debug_to_console(password_hash($password, PASSWORD_DEFAULT));
        debug_to_console($passwordHashed);
        //header("Location: ../login.php?error=wrongLogin2");

        exit();
    } else if ($checkPassword === true) {
        session_start();
        $_SESSION["userid"] = $uidExists["id"];
        $_SESSION["username"] = $uidExists["username"];
        $_SESSION["useremail"] = $uidExists["email"];
        $_SESSION["userfirst_name"] = $uidExists["first_name"];
        $_SESSION["userlast_name"] = $uidExists["last_name"];
        $_SESSION["userphone"] = $uidExists["phone"];
        $_SESSION["useraddress"] = $uidExists["address"];
        $_SESSION["useris_admin"] = $uidExists["is_admin"];
        header("Location: ../index.php?error=succesLogin");
        exit();
    }
}
///////////////////////////////////////////////////////////////////////////////////////////////////////
/// Sekcja funkcji sprawdzających inputy                                                          /////
/// Anty XSS i sqlInjection                         ///////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////
function secure_input_XSS($input): string
{
    $secure_input = htmlspecialchars(strip_tags(trim($input)), ENT_QUOTES, 'UTF-8');
    return $secure_input;
}
function secure_sql($input): string
{
    $secure_input = mysqli_real_escape_string($conn, $input);
    return $secure_input;
}
function secure_input($input): string
{
    $secure_input = secure_input_XSS($input);
    $secure_input = secure_sql($input);
    return $secure_input;
}
///////////////////////////////////////////////////////////////////////////////////////////////////////
/// Debugowanie funkji                                                                           /////
/// Wyświetla dane w konsoli przeglądarki                                                          /////
///////////////////////////////////////////////////////////////////////////////////////////////////////
function debug_to_console($data) {
    $output = $data;
    if (is_array($output))
        $output = implode(',', $output);

    echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
}