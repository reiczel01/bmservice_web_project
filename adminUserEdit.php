<?php
session_start();

include_once 'php/dbHandler.inc.php'; // Zaimportuj połączenie z bazą danych
include_once 'php/functions.inc.php'; // Zaimportuj plik z funkcją getUserDataWithRoles

// Pobierz ID użytkownika z parametrów URL
$userId = isset($_GET['user_id']) ? $_GET['user_id'] : null;
//var_dump($userId);
if ($userId) {
    $user = getUserDataWithRoles($conn, $userId);
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
    <div class="container">
        <table class="product-display-table">
            <thead>
            <tr>
                <th>ID</th>
                <th>E-mail</th>
                <th>Login</th>
                <th>Rola</th>
                <th>Akcja</th>
            </tr>
            </thead>
            <?php if ($user): ?>
                <form action="php/userEdit.inc.php" method="POST">
                    <td><input type="text" name="user_id" value="<?php echo htmlspecialchars($user['user_id']); ?>" readonly></td>
                    <td><input type="text" name="email" value="<?php echo htmlspecialchars($user['email']); ?>"></td>
                    <td><input type="text" name="username" value="<?php echo htmlspecialchars($user['username']); ?>"></td>
                    <td>
                        <select name="role_name">
                            <option value="admin" <?php echo ($user['role_name'] == 'admin') ? 'selected' : ''; ?>>admin</option>
                            <option value="tech" <?php echo ($user['role_name'] == 'tech') ? 'selected' : ''; ?>>tech</option>
                            <option value="user" <?php echo ($user['role_name'] == 'user') ? 'selected' : ''; ?>>user</option>
                        </select>
                    </td>
                    <td><button type="submit" class="btn"> Zapisz </button></td>
                </form>
            <?php endif; ?>
        </table>
    </div>
</div>
<!-- Reszta kodu -->
</body>
</html>
