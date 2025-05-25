<?php

namespace Classes;

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
		$mail->Subject = 'Confirma tu Cuenta';

		$mail->isHTML(true);
		$mail->CharSet = 'UTF-8';
		$mail->Body = "
            <html>
                <p><strong>Hola {$this->nombre}</strong>, tu cuenta ha sido creada, pero es necesario confirmarla.</p>
                <p><a href='{$_ENV['HOST']}/confirmar-cuenta?token={$this->token}'>Confirmar Cuenta</a></p>
            </html>
        ";




		// $mail->SMTPDebug = SMTP::DEBUG_SERVER; 

		$mail->send();
	}

	public function enviarInstrucciones()
	{
		$mail = new PHPMailer();
		$this->configurarSMTP($mail);

		$mail->setFrom($_ENV['EMAIL_USER'], 'Trabajo Final');
		$mail->addAddress($this->email, $this->nombre);
		$mail->Subject = 'Reestablece tu contraseña';

		$mail->isHTML(true);
		$mail->CharSet = 'UTF-8';
		$mail->Body = "
            <html>
                <p><strong>Hola {$this->nombre}</strong>, has solicitado reestablecer tu contraseña.</p>
                <p><a href='{$_ENV['HOST']}/reestablecer?token={$this->token}'>Reestablecer contraseña</a></p>
            </html>
        ";

		// $mail->SMTPDebug = SMTP::DEBUG_SERVER; 

		$mail->send();
	}
}
