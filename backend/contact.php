<?php
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';
require '../PHPMailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize form data
    $date = htmlspecialchars($_POST['date']);
    $name = htmlspecialchars($_POST['name']);
    $contact = htmlspecialchars($_POST['contact']);
    $email = htmlspecialchars($_POST['email']);
    $pickup_address = htmlspecialchars($_POST['pickup_address']);
    $persons = htmlspecialchars($_POST['persons']);
    $package = htmlspecialchars($_POST['package']);

    // Create PHPMailer instance
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'hamza786504@gmail.com'; // Your Gmail address
        $mail->Password = 'yhyf oqgb hnxb ckot'; // Your app password (see below)
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // SSL/TLS
        $mail->Port = 465; // 465 for SSL, 587 for TLS

        // Recipients
        $mail->setFrom('hamza786504@gmail.com', 'GO Desserts Booking');
        $mail->addAddress('hamza786504@gmail.com', 'GO Desserts Info');
        $mail->addReplyTo($email, $name);

        // Content
        $mail->isHTML(true);
        $mail->Subject = "New Booking Request - " . $package . " Package";
        
        // Responsive HTML email template
        $mail->Body = '
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>New Booking</title>
            <style>
                body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; margin: 0; padding: 0; }
                .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                .header { background-color: #f8f8f8; padding: 20px; text-align: center; }
                .content { padding: 20px; }
                table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
                table td { padding: 12px; border: 1px solid #ddd; }
                table tr:nth-child(even) { background-color: #f9f9f9; }
                .footer { margin-top: 20px; padding: 20px; background-color: #f8f8f8; text-align: center; font-size: 12px; color: #777; }
                @media only screen and (max-width: 600px) {
                    table { font-size: 14px; }
                    .container { padding: 10px; }
                    table td { padding: 8px; }
                }
            </style>
        </head>
        <body>
            <div class="container">
                <div class="header">
                    <h2 style="margin: 0; color: #333;">New Booking Request</h2>
                    <p style="margin: 5px 0 0; font-size: 18px; color: #666;">' . $package . ' Package</p>
                </div>
                <div class="content">
                    <table>
                        <tr><td style="width: 30%;"><strong>Date:</strong></td><td>' . $date . '</td></tr>
                        <tr><td><strong>Name:</strong></td><td>' . $name . '</td></tr>
                        <tr><td><strong>Contact:</strong></td><td>' . $contact . '</td></tr>
                        <tr><td><strong>Email:</strong></td><td>' . $email . '</td></tr>
                        <tr><td><strong>Pickup Address:</strong></td><td>' . nl2br($pickup_address) . '</td></tr>
                        <tr><td><strong>No. of Persons:</strong></td><td>' . $persons . '</td></tr>
                        <tr><td><strong>Package:</strong></td><td>' . $package . '</td></tr>
                    </table>
                </div>
                <div class="footer">
                    <p style="margin: 0;">This is an automated message. Please do not reply directly to this email.</p>
                </div>
            </div>
        </body>
        </html>
        ';

        // Plain text version for non-HTML mail clients
        $mail->AltBody = "New Booking Request\n\n" .
            "Package: $package\n" .
            "Date: $date\n" .
            "Name: $name\n" .
            "Contact: $contact\n" .
            "Email: $email\n" .
            "Pickup Address: $pickup_address\n" .
            "No. of Persons: $persons\n";

        $mail->send();
        echo "success";
    } catch (Exception $e) {
        error_log("Mailer Error: " . $mail->ErrorInfo);
        echo "error";
    }
} else {
    echo "Invalid request method";
}
?>