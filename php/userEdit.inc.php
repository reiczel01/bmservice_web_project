<?php

include_once 'dbHandler.inc.php';

if (isset($_POST['user_id'], $_POST['email'], $_POST['username'], $_POST['role_name'])) {
    // Pobierz dane z formularza
    $userId = $_POST['user_id'];
    $email = $_POST['email'];
    $userName = $_POST['username'];
    $roleName = $_POST['role_name'];

    // Przygotuj zapytanie SQL do aktualizacji danych użytkownika
    $query = "UPDATE users SET email = ?, username = ? WHERE user_id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "ssi", $email, $userName, $userId);
    mysqli_stmt_execute($stmt);

    // Przygotuj zapytanie SQL do aktualizacji roli użytkownika
    $query = "UPDATE roles SET role_name = ? WHERE user_id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "si", $roleName, $userId);
    mysqli_stmt_execute($stmt);

    // Przekieruj z powrotem do strony admina
    header("Location: /adminPanelUsers.php?success=userupdated");
    exit();
} else {
    // Jeżeli dane z formularza nie są ustawione, przekieruj z powrotem do strony admina z komunikatem o błędzie
    header("Location: /adminPanelUsers.php?error=nouserdata");
    exit();
}