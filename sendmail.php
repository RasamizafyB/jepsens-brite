<?php

    
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    require 'vendor/phpmailer/phpmailer/src/Exception.php';
    require 'vendor/phpmailer/phpmailer/src/PHPMailer.php';
    require 'vendor/phpmailer/phpmailer/src/SMTP.php';
    
    $mail = new PHPMailer();
    $mail->IsSMTP();
    $mail->Mailer = "smtp";
    $mail->SMTPDebug  = 1;  
    $mail->SMTPAuth   = TRUE;
    $mail->SMTPSecure = "tls";
    $mail->Port       = 587;
    $mail->Host       = "smtp.gmail.com";
    $mail->Username   = "bryanrasamizafy98@gmail.com";
    $mail->Password   = "Beloha98";

    $mail->IsHTML(true);
    $mail->AddAddress("rasamizafybryan98@gmail.com", "Brybry");
    $mail->SetFrom("bryanrasamizafy98@gmail.com", "JEPSENS-BRITE");
    $mail->AddReplyTo("rasamizafybryan98@gmail.com", "Brybry");
    $mail->AddCC("cc-recipient-email@domain", "cc-recipient-name");
    $mail->Subject = "Test is Test Email sent via Gmail SMTP Server using PHP Mailer";
    $content = "<b>This is a Test Email sent via Gmail SMTP Server using PHP mailer class.</b>";

    $mail->MsgHTML($content); 
    $mail->send();
?>
