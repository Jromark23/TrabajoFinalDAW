<?php

namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;

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

	public function enviarConfirmacion()
	{
		$mail = new PHPMailer();
		$mail->isSMTP();
		$mail->Host = $_ENV['EMAIL_HOST'];
		$mail->SMTPAuth = true;
		$mail->Port = $_ENV['EMAIL_PORT'];
		$mail->Username = $_ENV['EMAIL_USER'];
		$mail->Password = $_ENV['EMAIL_PASS'];

		$mail->setFrom('trabajofinal@joelroman.com');
		$mail->addAddress($this->email, $this->nombre);
		$mail->Subject = 'Confirma tu Cuenta';

		// Set HTML
		$mail->isHTML(TRUE);
		$mail->CharSet = 'UTF-8';

		$contenido = '<html>';
		$contenido .= "<p><strong>Hola " . $this->nombre .  "</strong> tu cuenta ha sido creada, pero es necesario confirmarla.</p>";
		$contenido .= "<p>Presiona aquí: <a href='" . $_ENV['HOST'] . "/confirmar-cuenta?token=" . $this->token . "'>Confirmar Cuenta</a>";
		$contenido .= '</html>';
		$mail->Body = $contenido;

		//Enviar el mail
		$mail->send();
	}

	public function enviarInstrucciones()
	{

		$mail = new PHPMailer();
		$mail->isSMTP();
		$mail->Host = $_ENV['EMAIL_HOST'];
		$mail->SMTPAuth = true;
		$mail->Port = $_ENV['EMAIL_PORT'];
		$mail->Username = $_ENV['EMAIL_USER'];
		$mail->Password = $_ENV['EMAIL_PASS'];

		$mail->setFrom('trabajofinal@joelroman.com');
		$mail->addAddress($this->email, $this->nombre);
		$mail->Subject = 'Reestablece tu password';

		// Set HTML
		$mail->isHTML(TRUE);
		$mail->CharSet = 'UTF-8';

		$contenido = '<html>';
		$contenido .= "<p><strong>Hola " . $this->nombre .  "</strong> Has solicitado reestablecer tu contraseña, sigue el siguiente enlace para hacerlo.</p>";
		$contenido .= "<p>Presiona aquí: <a href='" . $_ENV['HOST'] . "/reestablecer?token=" . $this->token . "'>Reestablecer contraseña</a>";
		$contenido .= '</html>';
		$mail->Body = $contenido;

		//Enviar el mail
		$mail->send();
	}
}
