<?php
session_start();
if(isset($_SESSION["userid"])) {
    include_once 'dbHandler.inc.php';
    include_once 'functions.inc.php';
    $user_id = $_SESSION["userid"];

    $usersAndRoles = getUsersAndRoles();

    foreach ($usersAndRoles as $user){
        echo '
        <tr>
                <td>'. $user["id"] . '</td>
                <td>'. $user["email"] .'</td>
                <td>'. $user["username"] .'</td>
                <td>'. $user["role_name"] .'</td>
                <td>
                    <a href="" class="btn"> <i class="fas fa-edit"></i> edit </a>
                    <a href="" class="btn"> <i class="fas fa-trash"></i> delete </a>
                </td>
            </tr>';
    }

}else {
    exit;
}