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
        $_SESSION["username"] = $uidExists["username"];
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
    $secure_input = htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
    return $secure_input;
}

function secure_sql($conn, $input): string
{
    $secure_input = mysqli_real_escape_string($conn, $input);
    return $secure_input;
}

function secure_input($conn, $input): string
{
    $secure_input = secure_input_XSS($input);
    $secure_input = secure_sql($conn, $secure_input);
    return $secure_input;
}

///////////////////////////////////////////////////////////////////////////////////////////////////////
/// Sekcja rejestracji pojazdu                                                                    /////
/// Są one wykonywane z cars.php i service.inc.php /////////////////////////////////////////////////
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
        header("Location: ../cars.php?error=stmtfailed");
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
        header("Location: ../cars.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "issssi", $user_id, $engine_designation, $model, $carRegistration, $vin, $year);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("Location: ../cars.php?error=none");
    exit();
}

///////////////////////////////////////////////////////////////////////////////////////////////////////
/// Sekcja tworzenia danych do tabeli cars                                                        /////
/// Są one wykonywane z cars.php i service.inc.php /////////////////////////////////////////////////
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
        // W razie niepowodzenia przekierowujemy użytkownika na stronę cars.php z informacją o błędzie
        header("Location: ../cars.php?error=stmtfailed");
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
/// Są one wykonywane z cars.php i service.inc.php /////////////////////////////////////////////////
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
            ORDER BY sr.date_requested ASC";

    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: ../cars.php?error=stmtfailed");
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

function getUsersDataById($conn, $userId) {
    // Zapytanie SQL
    $query = "SELECT * FROM users_data WHERE user_id = ?";

    // Przygotowanie zapytania
    $stmt = mysqli_prepare($conn, $query);

    // Przypisanie wartości do parametru zapytania
    mysqli_stmt_bind_param($stmt, "i", $userId);

    // Wykonanie zapytania
    mysqli_stmt_execute($stmt);

    // Pobranie wyników zapytania
    $result = mysqli_stmt_get_result($stmt);

    // Sprawdzenie, czy dane istnieją
    if (mysqli_num_rows($result) > 0) {
        // Pobranie wszystkich wierszy z wyników
        $userData = mysqli_fetch_all($result, MYSQLI_ASSOC);
        return $userData;
    } else {
        return null;
    }
}

function getRepeatedDates($conn) {

    // Zapytanie SQL
    $query = "SELECT date_requested
              FROM service_requests
              GROUP BY date_requested
              HAVING COUNT(*) > 3";

    // Przygotowanie zapytania
    $stmt = mysqli_prepare($conn, $query);

    // Wykonanie zapytania
    mysqli_stmt_execute($stmt);

    // Pobranie wyników zapytania
    $result = mysqli_stmt_get_result($stmt);

    // Przygotowanie tablicy na daty
    $dates = array();

    // Przejście przez wyniki i zapisanie dat do tablicy
    while ($row = mysqli_fetch_assoc($result)) {
        $date = $row['date_requested'];
        $dates[] = $date;
    }

    // Zwrócenie tablicy z datami
    return $dates;
}

function addServiceRequest($conn, $carId, $dataId, $description, $dateRequested, $mileage) {
    $carId = intval($carId);
    $dataId = intval($dataId);
    $description = mysqli_real_escape_string($conn, $description);
    $dateRequested = mysqli_real_escape_string($conn, $dateRequested);
    $mileage = intval($mileage);

    // Zapytanie SQL
    $query = "INSERT INTO service_requests (car_id, data_id, description, date_requested, milage) VALUES (?, ?, ?, ?, ?)";

    // Przygotowanie zapytania
    $stmt = mysqli_prepare($conn, $query);

    // Przypisanie wartości do parametrów zapytania
    mysqli_stmt_bind_param($stmt, "iisss", $carId, $dataId, $description, $dateRequested, $mileage);

    // Wykonanie zapytania
    $result = mysqli_stmt_execute($stmt);

    // Sprawdzenie, czy dodanie rekordu powiodło się
    if ($result) {
        return true; // Dodanie rekordu zakończone sukcesem
    } else {
        return false; // Dodanie rekordu nie powiodło się
    }
}


///////////////////////////////////////////////////////////////////////////////////////////////////////
/// Sekcja tworzenia i edytowania danych do adminPanel.php                                        /////
/// Są one wykonywane z adminPanel.php i adminPanel.inc.php //////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////
//TODO: Create function to list all service requests
//      add function to delete edit service requests
//      create option to edit user data
//      create option to delete user
function getUsersAndRoles($conn) {
    // Zapytanie SQL
    $sql = "SELECT users.user_id, users.email, users.username, roles.role_name
            FROM users
            LEFT JOIN roles ON users.user_id = roles.user_id
            ORDER BY users.user_id ASC";

    $result = $conn->query($sql);

    // Tablica do przechowywania wyników
    $data = array();

    // Pobieranie wyników zapytania
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data[] = array(
                'id' => $row['user_id'],
                'email' => $row['email'],
                'username' => $row['username'],
                'role_name' => $row['role_name']
            );
        }
    }

    // Zamknięcie połączenia z bazą danych
    $conn->close();

    // Zwrócenie danych
    return $data;
}
function deleteUser($conn, $userId) {
    // Define the queries
    $tables = array('cars', 'roles', 'users_data', 'users');

    // Execute the queries
    foreach($tables as $table) {
        $query = "DELETE FROM {$table} WHERE user_id = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "i", $userId);
        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_store_result($stmt);
            if(mysqli_stmt_affected_rows($stmt) == 0) {
                // If there were no rows to delete, continue to the next table
                continue;
            }
        } else {
            // Error occurred while executing the query
            echo "Error deleting record in table {$table}: " . mysqli_error($conn);
        }
        mysqli_stmt_close($stmt);
    }
}
function getUserDataWithRoles($conn, $userId) {
    // Przygotuj zapytanie SQL
    $query = "SELECT users.*, roles.role_name FROM users 
              LEFT JOIN roles ON users.user_id = roles.user_id
              WHERE users.user_id = ?";

    // Przygotuj i wykonaj zapytanie
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $userId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // Sprawdź, czy zapytanie zwróciło jakieś wyniki
    if(mysqli_num_rows($result) > 0){
        // Zwróć dane użytkownika
        return mysqli_fetch_assoc($result);
    } else {
        // Zwróć fałsz, jeśli użytkownik nie został znaleziony
        return false;
    }
}

function getUsersData($conn) {
    // Zapytanie SQL
    $sql = "SELECT * FROM users_data";

    $result = $conn->query($sql);

    // Tablica do przechowywania wyników
    $data = array();

    // Pobieranie wyników zapytania
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }

    // Zamknięcie połączenia z bazą danych
    $conn->close();

    // Zwrócenie danych
    return $data;
}
function deleteUserData($conn, $dataId) {
    // Przygotuj zapytanie SQL
    $query = "DELETE FROM users_data WHERE data_id = ?";

    // Przygotuj i wykonaj zapytanie
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $dataId);
    mysqli_stmt_execute($stmt);

    // Sprawdź, czy rekord został usunięty
    if (mysqli_stmt_affected_rows($stmt) > 0) {
        return true; // Zwróć prawdę jeśli rekord został usunięty
    } else {
        return false; // Zwróć fałsz jeśli rekord nie został usunięty
    }
}
function getUserDataById($conn, $dataId) {
    // Przygotuj zapytanie SQL
    $query = "SELECT * FROM users_data WHERE data_id = ?";

    // Przygotuj i wykonaj zapytanie
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $dataId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // Sprawdź, czy zapytanie zwróciło jakieś wyniki
    if(mysqli_num_rows($result) > 0){
        // Zwróć dane użytkownika
        return mysqli_fetch_assoc($result);
    } else {
        // Zwróć fałsz, jeśli dane nie zostały znalezione
        return false;
    }
}

function getAllCars($conn) {
    // Zapytanie SQL
    $query = "SELECT * FROM cars";

    // Wykonaj zapytanie
    $result = mysqli_query($conn, $query);

    // Tablica do przechowywania danych
    $cars = array();

    // Pobierz wyniki zapytania
    while ($row = mysqli_fetch_assoc($result)) {
        $cars[] = $row;
    }

    // Zwolnij pamięć zajmowaną przez wynik zapytania
    mysqli_free_result($result);

    // Zwróć tablicę z danymi
    return $cars;
}

function deleteCar($conn, $carId) {
    // Przygotuj zapytanie SQL do usunięcia samochodu
    $query = "DELETE FROM cars WHERE car_id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $carId);
    mysqli_stmt_execute($stmt);

    // Sprawdź, czy usunięto rekord
    if (mysqli_stmt_affected_rows($stmt) > 0) {
        // Rekord został pomyślnie usunięty
        return true;
    } else {
        // Nie udało się usunąć rekordu
        return false;
    }
}

function getCarDataById($conn, $carId) {
    // Przygotuj zapytanie SQL
    $query = "SELECT * FROM cars WHERE car_id = ?";

    // Przygotuj i wykonaj zapytanie
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $carId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // Sprawdź, czy zapytanie zwróciło jakieś wyniki
    if (mysqli_num_rows($result) > 0) {
        // Pobierz dane samochodu
        return mysqli_fetch_assoc($result);
    } else {
        // Jeżeli samochód nie został znaleziony, zwróć false
        return false;
    }
}

function getServiceData($conn) {
    $sql = "SELECT service_requests.*, service_realisations.*, 
                   service_realisations.description AS realisation_description,
                   service_requests.description AS request_description,
                     service_requests.request_id AS request_id_data,
                        service_realisations.request_id AS request_id_realisation
            FROM service_requests
            LEFT JOIN service_realisations ON service_requests.request_id = service_realisations.request_id";

    $result = $conn->query($sql);

    $data = array();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }

    return $data;
}

function deleteServiceRequest($conn, $requestId, $realisationId) {
    // Usunięcie zrealizowania serwisowego (jeśli istnieje)
    $query = "DELETE FROM service_realisations WHERE realisation_id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $realisationId);
    mysqli_stmt_execute($stmt);

    // Sprawdzenie, czy usunięto jakiekolwiek wiersze z tabeli service_realisations
    $deletedRealisations = mysqli_affected_rows($conn);

    // Usunięcie zgłoszenia serwisowego (jeśli istnieje)
    $query = "DELETE FROM service_requests WHERE request_id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $requestId);
    mysqli_stmt_execute($stmt);

    // Sprawdzenie, czy usunięto jakiekolwiek wiersze z tabeli service_requests
    $deletedRequests = mysqli_affected_rows($conn);

    // Sprawdzenie, czy usunięto jakiekolwiek wiersze w obu tabelach
    if ($deletedRealisations > 0 || $deletedRequests > 0) {
        // Zwrócenie true, jeśli usunięto zgłoszenie serwisowe
        return true;
    }

    // Zwrócenie false, jeśli nie usunięto zgłoszenia serwisowego
    return false;
}

function getServiceDataByRequestAndRealisationId($conn, $requestId, $realisationId) {
    $query = "SELECT * FROM service_requests
              WHERE request_id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $requestId);
    mysqli_stmt_execute($stmt);
    $requestData = mysqli_stmt_get_result($stmt);

    $query = "SELECT * FROM service_realisations
              WHERE realisation_id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $realisationId);
    mysqli_stmt_execute($stmt);
    $realisationData = mysqli_stmt_get_result($stmt);

    $data = array(
        'request_data' => null,
        'realisation_data' => null
    );

    if ($requestData && mysqli_num_rows($requestData) > 0) {
        $data['request_data'] = mysqli_fetch_assoc($requestData);
    }

    if ($realisationData && mysqli_num_rows($realisationData) > 0) {
        $data['realisation_data'] = mysqli_fetch_assoc($realisationData);
    }

    return $data;
}

function getTechnicianData($conn) {
    $sql = "SELECT users.*, users_data.*, roles.role_name
            FROM users
            LEFT JOIN users_data ON users.user_id = users_data.user_id
            INNER JOIN roles ON users.user_id = roles.user_id
            WHERE roles.role_name = 'tech'";

    $result = $conn->query($sql);

    $data = array();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }

    return $data;
}

function getUserDataByUsername($conn, $username)
{
    $query = "SELECT * FROM users_data WHERE user_id = (SELECT user_id FROM users WHERE username = '$username')";
    $result = mysqli_query($conn, $query);

    if (!$result || mysqli_num_rows($result) === 0) {
        return null; // Użytkownik o podanej nazwie nie istnieje
    }

    $user_data = mysqli_fetch_assoc($result);
    mysqli_free_result($result);

    return $user_data;
}

function getFirstRecord($conn, $data_id) {
    // Zabezpieczanie danych wejściowych
    $data_id = mysqli_real_escape_string($conn, $data_id);

    // Zapytanie SQL
    $query = "SELECT * FROM users_data WHERE data_id = $data_id LIMIT 1";

    // Wykonanie zapytania
    $result = mysqli_query($conn, $query);

    // Sprawdzanie, czy zapytanie zwróciło wynik
    if(mysqli_num_rows($result) > 0) {
        // Zwrócenie pierwszego wyniku
        return mysqli_fetch_assoc($result);
    }

    // Zwrócenie null, jeżeli nie znaleziono wyników
    return null;
}

///////////////////////////////////////////////////////////////////////////////////////////////////////
/// Funkcja wyświetlająca i dodające dane urzytkownika                                                      /////
/// //////////////////////////////////////////////////////////////////////////////////////////////////

function getUserData($conn, $userId) {
    $query = "SELECT * FROM users_data WHERE user_id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $userId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        $userData = mysqli_fetch_all($result, MYSQLI_ASSOC);
        return $userData;
    } else {
        return false;
    }
}

function registerUserData($conn, $user_id, $first_name, $last_name, $company_name, $vat_id, $address, $phone_number)
{
    $query = "INSERT INTO users_data (user_id, first_name, last_name, company_name, vat_id, address, phone_number) 
              VALUES (?, ?, ?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "issssss", $user_id, $first_name, $last_name, $company_name, $vat_id, $address, $phone_number);

    if (mysqli_stmt_execute($stmt)) {
        return true; // Rejestracja danych użytkownika zakończona sukcesem
    } else {
        return false; // Błąd podczas rejestracji danych użytkownika
    }
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