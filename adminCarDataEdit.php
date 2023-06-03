<?php
session_start();

include_once 'php/dbHandler.inc.php'; // Zaimportuj połączenie z bazą danych
include_once 'php/functions.inc.php'; // Zaimportuj plik z funkcją getUserDataWithRoles

// Pobierz ID użytkownika z parametrów URL
$carId = isset($_GET['car_id']) ? $_GET['car_id'] : null;
if ($carId) {
    $car = getCarDataById($conn, $carId);
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
            <th>Silnik</th>
            <th>Model</th>
            <th>VIN</th>
            <th>Nr rejestracyjny</th>
            <th>Rok produkcji</th>
            <th>Akcja</th>
        </tr>
        </thead>
        <?php if ($car): ?>
            <form action="php/carDataEdit.inc.php" method="POST">
                <td style="display: none"><input type="text" name="car_id" value="<?php echo htmlspecialchars($carId); ?>" readonly></td>
                <td><input style="width: 15%" type="text" name="user_id" value="<?php echo htmlspecialchars($car['user_id']); ?>" readonly></td>
                <td><input style="width: 30%" type="text" name="make" value="<?php echo htmlspecialchars($car['make']); ?>"></td>
                <td><input style="width: 30%" type="text" name="model" value="<?php echo htmlspecialchars($car['model']); ?>"></td>
                <td><input style="width: 70%" type="text" name="vin" value="<?php echo htmlspecialchars($car['vin']); ?>"></td>
                <td><input style="width: 50%" type="text" name="registration_nr" value="<?php echo htmlspecialchars($car['registration_nr']); ?>"></td>
                <td>
                    <select name="production_year">
                        <?php
                        $currentYear = date("Y");
                        $startYear = 1950;
                        for ($year = $startYear; $year <= $currentYear; $year++) {
                            $selected = ($year == $car['production_year']) ? 'selected' : '';
                            echo "<option value='$year' $selected>$year</option>";
                        }
                        ?>
                    </select>
                </td>
                <td><button type="submit" class="btn"> Zapisz </button></td>
            </form>
        <?php endif; ?>
    </table>

</div>
</body>
</html>
