<?php
session_start();
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
            <?php
            include('php/displayUsersTable.inc.php');
            ?>
            <!--<tr>
                <td>3</td>
                <td>mat@mat.com</td>
                <td>mat</td>
                <td>admin</td>
                <td>
                    <a href="admin_update.php?edit=<?php /*echo htmlspecialchars($row['ProduktID']); */?>" class="btn"> <i class="fas fa-edit"></i> edit </a>
                    <a href="admin_page.php?delete=<?php /*echo htmlspecialchars($row['ProduktID']); */?>" class="btn"> <i class="fas fa-trash"></i> delete </a>
                </td>
            </tr>-->
        </table>
    </div>
</div>
