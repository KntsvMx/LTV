<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = $_POST["full_name"];
    $email = $_POST["email"];
    $position = $_POST["position"]; 
    $phone = $_POST["phone"];
    $resume = $_POST["resume"];
    $file = $_FILES["file"];

    // Set recipient email address
    $to = "offer@ltv.kiev.ua";

    // Set email subject
    $subject = "Resume Submission from $full_name";

    // Set email headers
    $headers = "From: $email\r\n";
    $headers .= "Reply-To: $email\r\n";

    // Check if file is uploaded
    if (isset($file) && $file["error"] == 0) {
        // Get file info
        $file_name = basename($file["name"]);
        $file_type = $file["type"];
        $file_size = filesize($file["tmp_name"]);

        // Read file content into a variable
        $handle = fopen($file["tmp_name"], "r");
        $content = fread($handle, $file_size);
        fclose($handle);

        // Encode file content for sending in email
        $content = chunk_split(base64_encode($content));

        // Generate a boundary string
        $semi_rand = md5(time());
        $mime_boundary = "==Multipart_Boundary_x{$semi_rand}x";

        // Add headers for file attachment// Add headers for text part of the message
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: multipart/mixed; boundary=\"{$mime_boundary}\"\r\n";




        // Add multipart boundary and file attachment to message body
        // Add text part of the message
        $body = "--{$mime_boundary}\r\n";
        $body .= "Content-Type: text/plain; charset=\"UTF-8\"\r\n";
        $body .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
        $body .= "Full Name: $full_name\n";
        $body .= "Position: $position\n";
        $body .= "Email: $email\n";
        $body .= "Phone: $phone\n";
        $body .= "Resume: $resume\n\r\n";
        $body .= "--{$mime_boundary}\r\n";
        $body .= "Content-Type: {$file_type};\r\n";
        $body .= " name=\"{$file_name}\"\r\n";
        $body .= "Content-Disposition: attachment;\r\n";
        $body .= " filename=\"{$file_name}\"\r\n";
        $body .= "Content-Transfer-Encoding: base64\r\n\r\n";
        $body .= "{$content}\r\n\r\n";
        $body .= "--{$mime_boundary}--\r\n";
    }


    $flgchk = mail($to, $subject, $body, $headers); 
    // $flgchk = true; 

    // Send email
    if ($flgchk) {
        echo "<script language='javascript' type='text/javascript'>
        showPopupMessage('$successMessage', true);
        </script>";  
    } else {
        echo "<script language='javascript' type='text/javascript'>
        showPopupMessage('$errorMessage', false);</script>";
    }
}
