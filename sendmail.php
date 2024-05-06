<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
$mail = new PHPMailer(true);

try {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = strip_tags(trim($_POST["name"]));
        $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
        $message = trim($_POST["message"]);

        // Validate inputs
        if (empty($name) || empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL) || empty($message)) {
            throw new Exception("Invalid input");
        }

        //Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.ionos.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'server@msaid.dev';
        $mail->Password = 's2k3e4-1';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // Recipients
        $mail->setFrom('server@msaid.dev', 'Web Contact Form');
        $mail->addAddress($email, $name); 

        // Sending email
        $mail->isHTML(true);
        $mail->Subject = 'New Message from Website Contact Form';
        $mail->Body    = "<b>Name:</b> {$name}<br><b>Email:</b> {$email}<br><b>Message:</b><br>{$message}";
        $mail->AltBody = "Name: {$name}\nEmail: {$email}\nMessage:\n{$message}";

        $mail->send();
    }
} catch (Exception $e) {
    echo "Error: {$mail->ErrorInfo}";
}
?>
