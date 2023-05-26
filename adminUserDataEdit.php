<?php
session_start();

include_once 'php/dbHandler.inc.php'; // Zaimportuj połączenie z bazą danych
include_once 'php/functions.inc.php'; // Zaimportuj plik z funkcją getUserDataWithRoles

// Pobierz ID użytkownika z parametrów URL
$dataId = isset($_GET['data_id']) ? $_GET['data_id'] : null;
//var_dump($dataId);
if ($dataId) {
    $user = getUserDataById($conn, $dataId);
    //var_dump($user);
}
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Moja pierwsza strona</title>
    <link rel="stylesheet" href="/css/bootstrap-impostor.css">
    <style type="text/css">
        @import url("css/data-table.css");
        @import url("css/car.css");
        @import url("scss/nav.css");
        @import url("scss/top-bar.css");
        @import url("scss/content.css");
        @import url("scss/btn.scss");
        @import url("https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0");
    </style>
</head>
<body>
<?php
include('top-bar.php');
include('nav.php');
?>
<div class="content" style="background: #2b343b; border-left: 10px solid #FFFFFF00; border-right: 10px solid #FFFFFF00;">

        <table class="product-display-table">
            <thead>
            <tr>
                <th>User</th>
                <th>Imie</th>
                <th>Nazwisko</th>
                <th>Nazwa Firmy</th>
                <th>NIP</th>
                <th>Adres</th>
                <th>Telefon</th>
                <th>Akcja</th>
            </tr>
            </thead>
            <?php if ($user): ?>
                <form action="php/userDataEdit.inc.php" method="POST">
                    <td style="display: none"><input type="text" name="data_id" value="<?php echo htmlspecialchars($dataId); ?>" readonly></td>
                    <td><input style="width: 15%" type="text" name="user_id" value="<?php echo htmlspecialchars($user['user_id']); ?>" readonly></td>
                    <td><input style="width: 50%" type="text" name="first_name" value="<?php echo htmlspecialchars($user['first_name']); ?>"></td>
                    <td><input style="width: 50%" type="text" name="last_name" value="<?php echo htmlspecialchars($user['last_name']); ?>"></td>
                    <td><input style="width: 70%" type="text" name="company_name" value="<?php echo htmlspecialchars($user['company_name']); ?>"></td>
                    <td><input style="width: 60%" type="text" name="vat_id" value="<?php echo htmlspecialchars($user['vat_id']); ?>"></td>
                    <td><input style="width: 70%" type="text" name="address" value="<?php echo htmlspecialchars($user['address']); ?>"></td>
                    <td><input style="width: 50%" type="text" name="phone_number" value="<?php echo htmlspecialchars($user['phone_number']); ?>"></td>
                    <td><button type="submit" class="btn"> Zapisz </button></td>
                </form>
            <?php endif; ?>
        </table>

</div>
<!-- Reszta kodu -->
</body>
</html>
