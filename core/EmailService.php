<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../vendor/autoload.php';

class EmailService {

    public static function sendResetLink($toEmail, $subject, $body) {
        $mail = new PHPMailer(true);

        try {
            // Configuración del servidor SMTP
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';    // o el servidor SMTP que uses
            $mail->SMTPAuth   = true;
            $mail->Username   = 'dmaestudiodev@gmail.com';  // tu correo
            $mail->Password   = 'xymq sswr uarj hmah';      // tu contraseña de aplicación
            $mail->SMTPSecure = 'tls';                  // o 'ssl'
            $mail->Port       = 587;                    // 465 para SSL

            // Remitente y destinatario
            $mail->setFrom('dmaestudiodev@gmail.com', 'Velitas y Momentos');
            $mail->addAddress($toEmail);

            // Contenido del correo
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = $body;

            // Enviar
            $mail->send();
            return true;

        } catch (Exception $e) {
            error_log("PHPMailer Error: " . $mail->ErrorInfo);
            return false;
        }
    }
}
