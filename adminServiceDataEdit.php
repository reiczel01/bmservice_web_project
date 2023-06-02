<?php
session_start();

include_once 'php/dbHandler.inc.php'; // Zaimportuj połączenie z bazą danych
include_once 'php/functions.inc.php'; // Zaimportuj plik z funkcją getUserDataWithRoles

// Pobierz ID użytkownika z parametrów URL
$request_id_data = isset($_GET['request_id_data']) ? $_GET['request_id_data'] : null;
$request_id_realisation = isset($_GET['request_id_realisation']) ? $_GET['request_id_realisation'] : null;
$realisation_date = isset($_GET['realisation_date']) ? $_GET['realisation_date'] : null;

if ($request_id_data ) {
    $service = getServiceDataByRequestAndRealisationId($conn, $request_id_data, $request_id_realisation);
}

$technicians = getTechnicianData($conn);

$car = null;
$defaultCarData = null;

if ($service) {

}
//var_dump($service['request_data']['description']);
//var_dump($service['request_data']['date_requested']);
//var_dump($service['request_data']['milage']);
//var_dump($service['request_data']['car_id']);
//var_dump($service['request_data']['user_id']);
//var_dump($service['request_data']['request_id']);
//
//var_dump($service['realisation_data']['date_realised']);
//var_dump($service['realisation_data']['description']);
//var_dump($service['realisation_data']['technician_id']);
//var_dump($service['realisation_data']['technician_name']);
//var_dump($service['realisation_data']['technician_last_name']);
//var_dump($service['realisation_data']['technician_phone']);
//var_dump($service['realisation_data']['request_id']);
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
    <div class="container">
        <?php if ($service): ?>
            <form action="php/serviceRequestEdit.inc.php" method="POST">

                <table class="product-display-table">
                    <thead>
                    <tr>
                        <th>Data zgłoszenia</th>
                        <th>Data realizacji</th>
                        <th>Przebieg</th>
                        <th>Technik</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td><input type="date" name="date_requested" value="<?php echo htmlspecialchars($service['request_data']['date_requested']); ?>"></td>
                        <td><input type="date" name="date_realised" value="<?php echo htmlspecialchars($realisation_date); ?>"></td>
                        <td><input type="text" name="milage" value="<?php echo htmlspecialchars($service['request_data']['milage']); ?>"> KM</td>
                        <td>
                            <select name="technican_username">
                                <?php foreach ($technicians as $technician): ?>
                                    <option value="<?php echo $technician["username"]; ?>" <?php if ($technician["username"] === $service["technican_name"]) echo "selected"; ?>><?php echo $technician["username"]; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                    </tr>
                    </tbody>
                </table>

                <table class="product-display-table">
                    <thead>
                    <tr>
                        <th>Opis usterki</th>
                        <th>Wykonane prace</th>
                        <th>Akcja</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td><textarea name="request_description" rows="5" cols="40"><?php echo htmlspecialchars($service['request_data']['description']); ?></textarea></td>
                        <td><textarea name="realisation_description" rows="5" cols="40"><?php echo htmlspecialchars($service['realisation_data']['description']); ?></textarea></td>
                        <td><button type="submit" class="btn">Zapisz</button></td>
                        <td><input type="hidden" name="request_id" style="display: none" value="<?php echo htmlspecialchars($service['request_data']['request_id']); ?>"></td>

                    </tr>
                    </tbody>
                </table>

            </form>
        <?php endif; ?>
    </div>
</div>
<!-- Reszta kodu -->
</body>
</html>
