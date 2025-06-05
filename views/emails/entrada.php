<!-- views/emails/entrada.php -->
<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="UTF-8">
	<title>Tu Entrada</title>
	<style>
		body {
			font-family: Arial, sans-serif;
			color: #333;
		}

		.contenedor {
			max-width: 600px;
			margin: 0 auto;
			padding: 20px;
		}

		.logo {
			text-align: center;
			margin-bottom: 20px;
		}

		.logo img {
			max-width: 150px;
		}

		.contenido {
			background: #f9f9f9;
			border-radius: 8px;
			padding: 20px;
			text-align: center;
		}

		.contenido h2 {
			margin-top: 0;
			color: #0066cc;
		}

		.qr-container {
			margin: 20px 0;
		}

		.qr-container img {
			width: 200px;
			height: 200px;
		}

		.footer {
			margin-top: 30px;
			font-size: 0.8rem;
			color: #777;
			text-align: center;
		}

		.footer a {
			color: #0066cc;
			text-decoration: none;
		}
	</style>
</head>

<body>
	<div class="contenedor">
		<div class="logo" style="text-align:center; margin-bottom:20px;">
			<img src="<?= $logoUrl ?>" alt="Logo Trabajo Final" style="max-width:150px;">
		</div>
		<div class="contenido" style="background:#f9f9f9; border-radius:8px; padding:20px; text-align:center;">
			<h2>¡Hola <?= $nombre ?>!</h2>
			<p>Gracias por adquirir tu entrada para el evento.</p>
			<p>Te enviamos a continuación tu código QR, el cual podrás escanear al llegar al evento:</p>
			<div class="qr-container" style="margin:20px 0;">
				<img src="<?= $urlQrPublica ?>" alt="Código QR de tu entrada" style="width:200px; height:200px;">
			</div>
			<p>Si no puedes ver la imagen, copia y pega el siguiente enlace en tu navegador:</p>
			<p><a href="<?= $urlQrPublica ?>"><?= $urlQrPublica ?></a></p>
			<p>También puedes ver tu entrada online en este enlace:</p>
			<p><a href="<?= $enlaceEntrada ?>"><?= $enlaceEntrada ?></a></p>
		</div>
		<div class="footer" style="margin-top:30px; font-size:0.8rem; color:#777; text-align:center;">
			<p>Si no solicitaste esta entrada, ignora este mensaje.</p>
			<p style="margin-top:10px;">
				<a href="<?= $polCookies ?>">Política de Cookies</a> |
				<a href="<?= $polPrivacy ?>">Política de Privacidad</a> |
				<a href="<?= $darseBaja ?>">Darse de baja</a>
			</p>
		</div>
	</div>
</body>

</html>