<?php
if(isset($_POST['carRegistration-submit'])){
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $message = $_POST['message'];

    // Adres e-mail, na który ma zostać wysłana wiadomość
    $to = 'reiczel.01@gmail.com';

    // Temat wiadomości
    $subject = 'Nowa wiadomość ze formularza kontaktowego';

    // Treść wiadomości
    $emailContent = "Imię: $name\n";
    $emailContent .= "Nazwisko: $surname\n";
    $emailContent .= "E-mail: $email\n";
    $emailContent .= "Telefon: $phone\n\n";
    $emailContent .= "Wiadomość:\n$message";

    // Nagłówki wiadomości
    $headers = "From: $name $surname <$email>\r\n";
    $headers .= "Reply-To: $email\r\n";

    // Wysłanie wiadomości e-mail
    if(mail($to, $subject, $emailContent, $headers)){
        echo '<script>alert("Wiadomość została wysłana pomyślnie.");';
        echo 'window.location.href = "/contact.php";</script>';
    } else{
        echo '<script>alert("Wysłanie wiadomości nie powiodło się.");';
        echo 'window.location.href = "/contact.php";</script>';
    }
}
