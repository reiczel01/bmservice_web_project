<?php
session_start();
if(isset($_SESSION["userid"])) {
    include_once 'dbHandler.inc.php';
    include_once 'functions.inc.php';
    $user_id = $_SESSION["userid"];

    $usersAndRoles = getUsersAndRoles($conn);

    foreach ($usersAndRoles as $user){
        echo '
        <tr>
                <td>'. $user["id"] . '</td>
                <td>'. $user["email"] .'</td>
                <td>'. $user["username"] .'</td>
                <td>'. $user["role_name"] .'</td>
                <td style="padding: 1rem">
                    <a href="" class="btn"> <span class="material-symbols-outlined">edit</span></a>
                    <a href="php/deleteUser.inc.php?user_id='.$user["id"].'" class="btn-danger"><span class="material-symbols-outlined">delete_forever</span></a>
                </td>
            </tr>';
    }

}else {
    exit;
}