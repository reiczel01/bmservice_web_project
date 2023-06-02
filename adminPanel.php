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
            @import url("scss/btn.css");
            @import url("scss/top-bar.css");
            @import url("scss/content.css");
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
                <th>Panele</th>
                <th>akcja</th>
            </tr>
            </thead>
                <tr>
                    <td>Panel urzytkowników</td>
                    <td>
                        <a href="/adminPanelUsers.php" class="btn"> <i class="fas fa-edit"></i> Przejdź </a>
                    </td>
                </tr>
                <tr>
                    <td>Panel adresów</td>
                    <td>
                        <a href="/adminPanelUsersData.php" class="btn"> <i class="fas fa-edit"></i> Przejdź </a>
                    </td>
                </tr>
                <tr>
                    <td>Panel samochodów</td>
                    <td>
                        <a href="/adminPanelCarData.php" class="btn"> <i class="fas fa-edit"></i> Przejdź </a>
                    </td>
                </tr>
                <tr>
                    <td>Panel zgłoszeń</td>
                    <td>
                        <a href="/adminPanelServiceData.php" class="btn"> <i class="fas fa-edit"></i> Przejdź </a>
                    </td>
                </tr>
        </table>
    </div>
</div>
