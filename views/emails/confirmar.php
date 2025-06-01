<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="UTF-8" />
	<title>Confirma tu Cuenta en Proyecto Joel</title>
</head>

<body style="margin:0; padding:0; background-color:#f4f4f4; font-family: Arial, sans-serif;">
	<table width="100%" cellpadding="0" cellspacing="0" style="background-color:#f4f4f4; padding: 20px 0;">
		<tr>
			<td align="center">
				<table width="600" cellpadding="0" cellspacing="0" style="background-color:#ffffff; border-radius:8px; overflow:hidden;">

					<tr>
						<td align="center" style="background-color:#0073e6; padding:20px 0;">
							<p>Nombre del proyecto cuando sepa</p>
						</td>
					</tr>

					<tr>
						<td style="padding:20px; color:#333333;">
							<h2 style="margin-top:0; color:#0073e6;">Hola, <?= htmlspecialchars($nombre) ?>:</h2>
							<p style="font-size:16px; line-height:1.5; margin-bottom:20px;">
								Tu cuenta ha sido creada en <strong>Proyecto Joel</strong>, pero es necesario que la confirmes.
								Para activar tu usuario, haz clic en el botón de abajo:
							</p>
							<p style="font-size:16px; margin-bottom:20px;">
								<strong>Este enlace caduca en 24 horas.</strong>
							</p>
						</td>
					</tr>

					<tr>
						<td align="center" style="padding:20px;">
							<a href="<?= $enlace ?>"
								style="background-color:#0073e6; color:#ffffff; text-decoration:none; padding:12px 24px; border-radius:4px; font-size:16px; display:inline-block;">
								Confirmar Cuenta
							</a>
						</td>
					</tr>

					<tr>
						<td style="background-color:#f9f9f9; padding:20px; color:#666666; font-size:12px; text-align:center;">
							<p style="margin:0;">
								Este mensaje puede contener cookies de seguimiento para mejorar nuestros servicios.
								Para más información, consulta nuestra
								<a href="<?= $polCookies ?>" style="color:#0073e6; text-decoration:none;">
									Política de Cookies
								</a>
								y
								<a href="<?= $polPrivac ?>" style="color:#0073e6; text-decoration:none;">
									Política de Privacidad
								</a>.
							</p>
							<p style="margin:10px 0 0;">
								Si prefieres no recibir estos correos, pulsa
								<a href="<?= $darseBaja ?>" style="color:#0073e6; text-decoration:none;">
									aquí para darte de baja
								</a>.
							</p>
						</td>
					</tr>

				</table>
			</td>
		</tr>
	</table>
</body>

</html>