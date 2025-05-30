<?php
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';
require '../PHPMailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


if ($_SERVER["REQUEST_METHOD"] == "POST") {


    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "invalid";
        exit;
    }

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'hamza786504@gmail.com';
        $mail->Password = 'yhyf oqgb hnxb ckot';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = 465;

        $mail->setFrom('hamza786504@gmail.com', 'Newsletter Signup');
        $mail->addAddress('hamza786504@gmail.com'); // Send to yourself or your CRM
        $mail->addReplyTo($email);

        $mail->isHTML(true);
        $mail->Subject = "New Newsletter Subscriber";
        $mail->Body = "<p><strong>New subscriber:</strong> $email</p>";
        $mail->AltBody = "New subscriber: $email";

        $mail->send();
        echo "success";
    } catch (Exception $e) {
        error_log("Newsletter Error: " . $mail->ErrorInfo);
        echo "error";
    }
} else {
    echo "Invalid request";
}
?>
