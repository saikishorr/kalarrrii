<?php
use PHPMailer\PHPMailer\PHPMailer; 
use PHPMailer\PHPMailer\Exception; 
 
require 'vendor\phpmailer\phpmailer\src\PHPMailer.php';
require 'vendor\phpmailer\phpmailer\src\Exception.php';
require 'vendor\phpmailer\phpmailer\src\SMTP.php';
 
if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);

    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // SMTP server
        $mail->SMTPAuth = true;
        $mail->Username = 'saikishorrasala418@gmail.com'; // Your email
        $mail->Password = 'Sujata@143'; // Your email password or app-specific password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Recipients
        $mail->setFrom('your-email@gmail.com', 'Your Company Name');
        $mail->addAddress($email, $name);

        // Content
        $mail->isHTML(true);
        $mail->Subject = "Thank you for your submission, $name!";
        $mail->Body = "
        <h3>Hi $name,</h3>
        <p>Thank you for reaching out to us. Here are the details you provided:</p>
        <p><b>Name:</b> $name</p>
        <p><b>Email:</b> $email</p>
        <p><b>Message:</b> $message</p>
        <p>We will get back to you shortly.</p>
        <p>Best regards,<br>Your Company Name</p>
        ";

        // Send the email
        $mail->send();
        echo "Email has been sent successfully to $email.";
    } catch (Exception $e) {
        echo "Failed to send email. Error: {$mail->ErrorInfo}";
    }
} else {
    echo "Invalid request.";
}



?>
