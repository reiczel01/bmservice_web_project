<?php
session_start();
if (isset($_SESSION["userid"])) {
    include_once 'dbHandler.inc.php';
    include_once 'functions.inc.php';
    $user_id = $_SESSION["userid"];

    $usersData = getUsersData($conn);
    //var_dump($usersData);
    foreach ($usersData as $user) {
        echo '
        <tr class="rq">
            <td>' . $user["user_id"] . '</td>
            <td>' . $user["first_name"] . '</td>
            <td>' . $user["last_name"] . '</td>
            <td>' . $user["company_name"] . '</td>
            <td>' . $user["vat_id"] . '</td>
            <td>' . $user["address"] . '</td>
            <td>' . $user["phone_number"] . '</td>
            <td style="padding: 1rem">
                <a href="../adminUserDataEdit.php?data_id=' . $user["data_id"] . '" class="btn"> <span class="material-symbols-outlined">edit</span></a>
                <a href="php/deleteUserData.inc.php?data_id=' . $user["data_id"] . '" class="btn-danger"><span class="material-symbols-outlined">delete_forever</span></a>
            </td>
        </tr>';
    }
} else {
    exit;
}
