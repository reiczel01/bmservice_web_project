<?php
///////////////////////////////////////////////////////////////////////////////////////////////////////
/// Sekcja funkcji sprawdzających i tworzących nowego urzytkownika                                /////
/// Są one wykonywane z signup.php i signup.inc.php ///////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////
session_start();
function emptyInputSignup($username, $email,$password, $passwordRepeat): bool
{
    if (empty($username) || empty($email) || empty($password) || empty($passwordRepeat)) {
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
    $sql = "SELECT * FROM users
  WHERE username = ? OR email = ?;
";
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

function createUser($conn, $username, $email, $password): void
{

    $sql = "INSERT INTO users (username, password, email) VALUES (?, ?, ?);";
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
    mysqli_stmt_bind_param($stmt, "sss", $username, $hashedPassword, $email);
    // wykonanie zapytania
    mysqli_stmt_execute($stmt);
    // zamykamy nasze zapytanie
    mysqli_stmt_close($stmt);
    header("Location: ../signup.php?error=none");

    $uidExists = uidExists($conn, $username, $email);
    if ($uidExists === false) {
        header("Location: ../login.php?error=userNotCreated");
        exit();
    }
    $userid = $uidExists["user_id"];
    $sql = "INSERT INTO roles (user_id, role_name) VALUES (?, ?);";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: ../signup.php?error=stmtfailed");
        exit();
    }
    $temp = "user";
    mysqli_stmt_bind_param($stmt, "is", $userid, $temp);
    // wykonanie zapytania
    mysqli_stmt_execute($stmt);
    // zamykamy nasze zapytanie
    mysqli_stmt_close($stmt);
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
        header("Location: ../login.php?error=wrongLogin");
        exit();
    }

    //jeśli urzytkownik istnieje to sprawdzamy czy podane hasło jest poprawne
    //$uidExists["password"] to hasło zapisane w bazie
    $passwordHashed = $uidExists["password"];
    //sprawdzamy czy podane hasło zgadza się z hasłem zapisanym w bazie
    //password_verify zwraca true lub false w zależności od tego czy hasła się zgadzają
    $checkPassword = password_verify($password, $passwordHashed);

    if ($checkPassword === false) {
        //debug_to_console(password_hash($password, PASSWORD_DEFAULT));
        //debug_to_console($passwordHashed);
        header("Location: ../login.php?error=wrongLogin");

        exit();
    } else if ($checkPassword === true) {
        session_start();
        $_SESSION["userid"] = $uidExists["user_id"];
        $_SESSION["useremail"] = $uidExists["email"];
        $sql = "SELECT role_name FROM roles WHERE user_id = ?;";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: ../signup.php?error=stmtfailed");
            exit();
        }
        mysqli_stmt_bind_param($stmt, "s", $uidExists["user_id"]);
        // wykonanie zapytania
        mysqli_stmt_execute($stmt);
        // pobieranie zanych z naszej bazy po wykonaniu zapytania
        $resultData = mysqli_stmt_get_result($stmt);
        $result = mysqli_fetch_assoc($resultData);
        $_SESSION["role"] = $result["role_name"];
        }
        header("Location: ../login.php?error=succesLogin");
        exit();

}
///////////////////////////////////////////////////////////////////////////////////////////////////////
/// Sekcja funkcji sprawdzających inputy                                                          /////
/// Anty XSS i sqlInjection                         ///////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////
function checkSession() : void
{
    if(session_status() == PHP_SESSION_NONE) {
        session_start();
    }
}

function isUserLoggedIn() {
    session_start(); // Uruchamiamy sesję
    if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
        // Jeśli zmienna sesyjna logged_in istnieje i ma wartość true, zwracamy true
        return true;
    } else {
        // W przeciwnym razie zwracamy false
        return false;
    }
}

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
/// Sekcja rejestracji pojazdu                                                                    /////
/// Są one wykonywane z service.php i service.inc.php /////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////
function emptyInputCar($carRegistration, $carVin, $carEngineDesignation, $carModel, $carYear): bool
{
    if (empty($carRegistration) || empty($carVin) || empty($carEngineDesignation) || empty($carModel) || empty($carYear)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}
function carRegistrationCheck($carRegistration): bool
{
    //sprawdzenie czy rejestracja posiada 7 znaków z czego minimum dwa są literami i czy nie ma znaków specjalnych
    if (preg_match('/^[A-Z]{2}[0-9]{5}$/', $carRegistration)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}
function carVinCheck($carVin): bool
{
    //sprawdzenie czy VIN posiada 7 znaków z czego minimum dwa są literami i czy nie ma znaków specjalnych
    if (preg_match('/^[A-Z0-9]{18}$/', $carVin)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}
function yearCheck($carYear): bool
{
    // Sprawdzenie, czy rok jest liczbą
    if (!is_numeric($carYear)) {
        debug_to_console("nie jest liczbą");
        return false;
    }
    // Przekształcenie roku na liczbę całkowitą
    $carYear = intval($carYear);
    // Sprawdzenie, czy rok jest większy niż 1900 i mniejszy lub równy bieżącemu roku
    if ($carYear >= 1900 && $carYear <= date('Y')) {
        return true;
    } else {
        return false;
    }
}
function carExists($conn, $carRegistration): bool
{
    $sql = "SELECT 
    user_id, make, model, registration_nr, vin, production_year, car_id 
    FROM cars 
    WHERE registration_nr = ?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: ../service.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $carRegistration);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultData)) {
        return $row;
    } else {
        $result = false;
        return $result;
    }

    mysqli_stmt_close($stmt);
}

function registerCar($conn, $user_id, $engine_designation, $model, $carRegistration, $vin, $year): void
{
    $sql = "INSERT INTO cars (user_id, make, model, registration_nr, vin, production_year) VALUES (?, ?, ?, ?, ?, ?);";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: ../service.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "issssi", $user_id, $engine_designation, $model, $carRegistration, $vin, $year);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("Location: ../service.php?error=none");
    exit();
}

///////////////////////////////////////////////////////////////////////////////////////////////////////
/// Sekcja tworzenia danych do tabeli cars                                                        /////
/// Są one wykonywane z service.php i service.inc.php /////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////
function createTwoDimensionalArrayOfCars($conn, $user_id) {
    // Tworzymy pustą dwuwymiarową tablicę, do której będą zapisywane wypisy z bazy danych
    $cars_array = array();

    // Tworzymy zapytanie SQL, które wybierze wypisy z bazy danych dla danego użytkownika
    $sql = "SELECT make, model, registration_nr, vin, production_year, car_id 
            FROM cars 
            WHERE user_id = ?;";

    // Inicjujemy przygotowanie do wykonania zapytania do bazy danych
    $stmt = mysqli_stmt_init($conn);

    // Sprawdzamy, czy przygotowanie się powiodło
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        // W razie niepowodzenia przekierowujemy użytkownika na stronę service.php z informacją o błędzie
        header("Location: ../service.php?error=stmtfailed");
        exit();
    }

    // Przypisujemy do zapytania wartość parametru, którym jest $user_id
    mysqli_stmt_bind_param($stmt, "s", $user_id);

    // Wykonujemy zapytanie do bazy danych
    mysqli_stmt_execute($stmt);

    // Zapisujemy wynik zapytania do zmiennej $resultData
    $resultData = mysqli_stmt_get_result($stmt);

    // Dopóki istnieją wiersze w wyniku zapytania, wykonujemy pętlę while
    while ($row = mysqli_fetch_assoc($resultData)) {
        // Tworzymy nową tablicę $car, w której zapiszemy dane z bieżącego wiersza z bazy danych
        $car = array(
            'make' => $row['make'],
            'model' => $row['model'],
            'registration_nr' => $row['registration_nr'],
            'vin' => $row['vin'],
            'production_year' => $row['production_year'],
            'car_id' => $row['car_id']
        );

        // Dodajemy tablicę $car do naszej dwuwymiarowej tablicy $cars_array
        $cars_array[] = $car;
    }

    // Zwracamy dwuwymiarową tablicę z wypisami pojazdów z bazy danych
    return $cars_array;
}

///////////////////////////////////////////////////////////////////////////////////////////////////////
/// Sekcja tworzenia danych do tabeli service_request                                             /////
/// Są one wykonywane z service.php i service.inc.php /////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////
function emptyServiceRequest($conn, $user_id, $car_id, $date_requested, $milage, $description) {
    if (empty($user_id) || empty($car_id) || empty($date_requested) || empty($milage) || empty($description)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}
function invalidMilage($milage): bool
{
    if (!is_numeric($milage)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}
function invalidDate($date): bool
{
    // Sprawdzenie czy data jest w formacie "Y-m-d"
    if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
        return false;
    }

    // Konwertowanie daty na obiekt DateTime
    $date_obj = DateTime::createFromFormat('Y-m-d', $date);

    // Sprawdzenie czy data jest nie wcześniejsza niż dzisiaj
    if ($date_obj < new DateTime('today')) {
        return false;
    }

    // Sprawdzenie czy data nie jest dzisiaj
    if ($date_obj->format('Y-m-d') === date('Y-m-d')) {
        return false;
    }

    // Data jest prawidłowa
    return true;
}

///////////////////////////////////////////////////////////////////////////////////////////////////////
/// Sekcja tworzenia danych do kart serwisowych                                                   /////
/// Są one wykonywane z serviceHistory.php i serviceRequestRealizationDisplay.inc.php /////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////

function createTwoDimensionalArrayOfServiceRequests($conn, $user_id)
{
    $cars_service = array();

    $sql = "SELECT c.model, c.make, c.registration_nr, sr.description AS request_description, sr.date_requested, sr.milage, srr.technican_name, srr.technican_last_name, srr.technican_phone, srr.date_realised, srr.description AS realisation_description
            FROM cars c
            LEFT JOIN service_requests sr ON c.car_id = sr.car_id
            LEFT JOIN service_realisations srr ON sr.request_id = srr.request_id
            WHERE c.user_id = ? AND sr.request_id IS NOT NULL
            ORDER BY sr.date_requested DESC";

    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: ../service.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "i", $user_id);

    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    while ($row = mysqli_fetch_assoc($resultData)) {
        $cars_service[] = $row;
    }

    return $cars_service;
}



///////////////////////////////////////////////////////////////////////////////////////////////////////
/// Debugowanie funkji                                                                            /////
/// Wyświetla dane w konsoli przeglądarki                                                         /////
///////////////////////////////////////////////////////////////////////////////////////////////////////
function debug_to_console($data) {
    $output = $data;
    if (is_array($output))
        $output = implode(',', $output);

    echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
}