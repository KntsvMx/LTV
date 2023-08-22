<?php
if($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = $_POST["full_name"];
    $email = $_POST["email"]; 
    $phone = $_POST["phone"];
    $resume = $_POST["resume"];

    $to = "kuntesvish@gamil.com"; 
    $subject = "Нове резюме";
    $message = "ПІБ: $full_name\n Email: $email\n Телефон: $phone\n \n Резюме: \n$resume";  
    
    $headers = "From $email";

    if(mail($to, $subject, $message, $headers)) {
        echo "Резюме відправлено успішно";
    } else {
        echo "Помилка, резюме не відправлено";
    }

}


?>