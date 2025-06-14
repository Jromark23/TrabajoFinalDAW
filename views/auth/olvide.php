<main class="auth">
	<h2 class="auth__heading">
		<?= $titulo; ?>
	</h2>
	<p class="auth__texto"> Recupera tu contraseña </p>

	<?php require_once __DIR__ . '/../templates/alertas.php'; 	?>


	<form class="formulario" method="post" action="/olvide">
		<?= csrf() ?>
		<div class="formulario__campo">
			<label for="email" class="formulario__label">
				Email
			</label>
			<input class="formulario__input" type="email" name="email" id="email" placeholder="correo@correo.com">
		</div>

		<input type="submit" class="formulario__submit" value="Enviar">
	</form>

	<div class="acciones">
		<a href="/login" data-scroll="inicio" class="acciones__enlace">Iniciar sesión</a>
		<a href="/registro" data-scroll="inicio" class="acciones__enlace">¿No tienes cuenta? Registrarse</a>
	</div>
</main>