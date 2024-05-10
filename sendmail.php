<?php
require __DIR__ . '/vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

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
        $mail->Host = $_ENV['SMTP_HOST'];
        $mail->SMTPAuth = true;
        $mail->Username = $_ENV['SMTP_USERNAME'];
        $mail->Password = $_ENV['SMTP_PASSWORD'];
        $mail->SMTPSecure = $_ENV['SMTP_SECURE'];
        $mail->Port = $_ENV['SMTP_PORT'];

        // Recipients
        $mail->setFrom($_ENV['FROM_EMAIL'], $_ENV['FROM_NAME']);
        $mail->addAddress('mo-45@hotmail.com', 'Your Name');
        
        // Email subject
        $subject = 'Inquiry from ' . $email . ' sent via Web Contact Form';
        $mail->Subject = $subject;
        
        // Email body
        $body = "<b>Name:</b> {$name}<br><b>Email:</b> {$email}<br><b>Message:</b><br>{$message}";
        $mail->Body = $body;
        $mail->AltBody = "Name: {$name}\nEmail: {$email}\nMessage:\n{$message}";
        
        $mail->send();

        // Sending confirmation email to the user
        // Server settings
        $confirmationMail = new PHPMailer(true);
        $confirmationMail->isSMTP();
        $confirmationMail->Host = $_ENV['SMTP_HOST'];
        $confirmationMail->SMTPAuth = true;
        $confirmationMail->Username = $_ENV['SMTP_USERNAME'];
        $confirmationMail->Password = $_ENV['SMTP_PASSWORD'];
        $confirmationMail->SMTPSecure = $_ENV['SMTP_SECURE'];
        $confirmationMail->Port = $_ENV['SMTP_PORT'];

        // Recipients
        $confirmationMail->setFrom($_ENV['FROM_EMAIL'], $_ENV['FROM_NAME']);
        $confirmationMail->addAddress($email, $name);

        // Email subject
        $confirmationSubject = 'Message Sent Successfully';
        $confirmationMail->Subject = $confirmationSubject;

        // Email body
        $confirmationBody = "Dear {$name},<br><br>Your message has succesfully been sent. I will get back to you as soon as possible.<br><br>Thank you for contacting me.<br><br>Best regards,<br>Mohamed Said";
        $confirmationMail->Body = $confirmationBody;
        $confirmationMail->AltBody = "Dear {$name},\n\nYour message has succesfully been sent. I will get back to you as soon as possible.\n\nThank you for contacting me.\n\nBest regards,\nMohamed Said";
        $confirmationMail->send();
    }
} catch (Exception $e) {
    echo "Error: {$mail->ErrorInfo}";
}
header("Location: https://msaid.dev");
?>
