<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="UTF-8">
	<title>Confirma tu Cuenta</title>
	<style>
		body {
			font-family: Arial, sans-serif;
			color: #333;
			background: #f9f9f9;
			margin: 0;
			padding: 20px 0;
		}

		.contenedor {
			max-width: 600px;
			margin: 0 auto;
			background: #ffffff;
			border-radius: 8px;
			overflow: hidden;
			box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
		}

		.logo {
			text-align: center;
			margin-bottom: 20px;
			padding: 20px 0;
		}

		.logo img {
			max-width: 150px;
		}

		.contenido {
			padding: 20px;
			text-align: center;
		}

		.contenido h2 {
			margin-top: 0;
			color: #0066cc;
		}

		.contenido p {
			margin: 1rem 0;
		}

		.btn {
			display: inline-block;
			background: #0066cc;
			color: white;
			padding: 12px 24px;
			border-radius: 4px;
			text-decoration: none;
			font-size: 16px;
			margin: 1rem 0;
		}

		.footer {
			padding: 20px;
			font-size: 0.8rem;
			text-align: center;
			color: #777;
		}

		.footer a {
			color: #0066cc;
			text-decoration: none;
		}
	</style>
</head>

<body>
	<div class="contenedor">
		<div class="logo">
			<img src="<?= $logoUrl ?>" alt="Logo Trabajo Final">
		</div>
		<div class="contenido">
			<h2>¡Hola <?= htmlspecialchars($nombre) ?>!</h2>
			<p>Tu cuenta ha sido creada correctamente.</p>
			<p>Para activarla, haz clic en el botón de abajo:</p>
			<a
				href="<?= $enlace ?>"
				class="btn"
				style="
					display: inline-block;
					background-color: #0066cc;
					color: #ffffff !important;
					text-decoration: none !important;
					padding: 12px 24px;
					border-radius: 4px;
					font-size: 16px;
				">
				Confirmar Cuenta
			</a>

			<p><strong>Este enlace caduca en 24 horas.</strong></p>
			<p>Si no solicitaste esta cuenta, ignora este correo.</p>
		</div>
		<div class="footer">
			<p>
				<a href="<?= $polCookies ?>">Política de Cookies</a> |
				<a href="<?= $polPrivacy ?>">Política de Privacidad</a> |
				<a href="<?= $darseBaja ?>">Darse de baja</a>
			</p>
		</div>
	</div>
</body>

</html>