<?php
session_start();

// Sprawdzenie, czy przekazano identyfikator użytkownika
if (isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];
    include_once 'dbHandler.inc.php';
    include_once 'functions.inc.php';
    // Wykonaj operacje usuwania użytkownika o podanym identyfikatorze
    if (isset($_SESSION['user_id'])) {
        $current_user_id = $_SESSION['user_id'];

        // Sprawdzenie, czy aktualny użytkownik jest taki sam jak ten, którego chcemy usunąć
        if ($current_user_id == $user_id) {
            echo '
            <script>
            function showAlert() {
              alert("Nie możesz usunąć aktualnie zalogowanego użytkownika.");
            }
            </script>';
            header("Location: /adminPanelUsers.php?error=1");
            return;
        }else{
            deleteUser($user_id, $conn);
        }
    }
    // Dodaj odpowiedni kod do usunięcia użytkownika z bazy danych lub przeprowadzenia innej akcji

    // Przekierowanie do innej strony po usunięciu użytkownika
    header("Location: /adminPanelUsers.php");
    exit();
}