<?php

namespace Classes;

use Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

class Email
{

	public $email;
	public $nombre;
	public $token;

	public function __construct($email, $nombre, $token)
	{
		$this->email = $email;
		$this->nombre = $nombre;
		$this->token = $token;
	}
	private function configurarSMTP(PHPMailer $mail)
	{
		$mail->isSMTP();
		$mail->Host       = $_ENV['EMAIL_HOST'];
		$mail->SMTPAuth   = true;
		$mail->Username   = $_ENV['EMAIL_USER'];
		$mail->Password   = $_ENV['EMAIL_PASS'];
		$mail->SMTPSecure = $_ENV['EMAIL_ENCRYPTION']; // 'ssl'
		$mail->Port       = (int) $_ENV['EMAIL_PORT'];

		// Opcional: desactivar verificación de certificados (solo si tienes errores SSL)
		$mail->SMTPOptions = [
			'ssl' => [
				'verify_peer'       => false,
				'verify_peer_name'  => false,
				'allow_self_signed' => true,
			],
		];
	}

	public function enviarConfirmacion()
	{
		$mail = new PHPMailer();
		$this->configurarSMTP($mail);

		$mail->setFrom($_ENV['EMAIL_USER'], 'Trabajo Final');
		$mail->addAddress($this->email, $this->nombre);
		$mail->Subject = 'Confirma tu cuenta';

		$mail->isHTML(true);
		$mail->CharSet = 'UTF-8';

		// Variables para la plantilla
		$nombre       = $this->nombre;
		$enlace       = $_ENV['HOST'] . '/confirmar-cuenta?token=' . $this->token;
		$logoUrl      = $_ENV['HOST'] . '/img/logo-email.png';
		$polCookies   = $_ENV['HOST'] . '/politica-cookies';
		$polPrivacy   = $_ENV['HOST'] . '/politica-privacidad';
		$darseBaja    = $_ENV['HOST'] . '/desuscribirse';

		// Cargar la plantilla HTML en un buffer y limpiarlo despues
		ob_start();
		require __DIR__ . '/../views/emails/confirmar.php';
		$htmlBody = ob_get_clean();

		$mail->Body    = $htmlBody;
		try {
            $mail->send();
        } catch (Exception $e) {
            error_log("Error al enviar correo de entrada a {$this->email}: {$mail->ErrorInfo}");
        }
	}

	public function enviarInstrucciones()
	{
		$mail = new PHPMailer();
		$this->configurarSMTP($mail);

		$mail->setFrom($_ENV['EMAIL_USER'], 'Congrexia Events');
		$mail->addAddress($this->email, $this->nombre);
		$mail->Subject = 'Reestablece tu contraseña';

		$mail->isHTML(true);
		$mail->CharSet = 'UTF-8';
		// Variables para la plantilla
		$nombre       = $this->nombre;
		$enlace       = $_ENV['HOST'] . '/reestablecer?token=' . $this->token;
		$logoUrl      = $_ENV['HOST'] . '/img/logo-email.png';
		$polCookies   = $_ENV['HOST'] . '/politica-cookies';
		$polPrivacy   = $_ENV['HOST'] . '/politica-privacidad';
		$darseBaja    = $_ENV['HOST'] . '/desuscribirse';

		// Cargar plantilla HTML en buffer y limpiuar despues 
		ob_start();
		require __DIR__ . '/../views/emails/reestablecer.php';
		$htmlBody = ob_get_clean();

		$mail->Body    = $htmlBody;
		try {
            $mail->send();
        } catch (Exception $e) {
            error_log("Error al enviar correo de entrada a {$this->email}: {$mail->ErrorInfo}");
        }
	}

	public function enviarEntrada(string $urlQrPublica)
	{
		$mail = new PHPMailer();
		$this->configurarSMTP($mail);

		$mail->setFrom($_ENV['EMAIL_USER'], 'Congrexia Events');
		$mail->addAddress($this->email, $this->nombre);
		//$mail->Subject = 'Tu entrada para el evento «' . $nombrePaquete . '»';
		$mail->Subject = 'Tu entrada para el evento';

		$mail->isHTML(true);
		$mail->CharSet = 'UTF-8';

		// Variables para la plantilla 
        $nombre        = $this->nombre;
        $urlQrPublica  = $urlQrPublica;
        $enlaceEntrada = $_ENV['HOST'] . '/entrada?id=' . $this->token;
        $logoUrl       = $_ENV['HOST'] . '/public/build/img/logomd.webp';
        $polCookies    = $_ENV['HOST'] . '/politica-cookies';
        $polPrivacy    = $_ENV['HOST'] . '/politica-privacidad';
        $darseBaja     = $_ENV['HOST'] . '/desuscribirse';


        // Cargar la plantilla HTML en un buffer
        ob_start();
        require __DIR__ . '/../views/emails/entrada.php';
        $htmlBody = ob_get_clean();

        $mail->Body = $htmlBody;

        try {
            $mail->send();
        } catch (Exception $e) {
            error_log("Error al enviar correo de entrada a {$this->email}: {$mail->ErrorInfo}");
        }
	}
}
