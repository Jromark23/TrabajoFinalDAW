<main class="auth">
	<h2 class="auth__heading"> <?= $titulo; ?> </h2>

	<?php require_once __DIR__ . '/../templates/alertas.php'; 	?>


	<form class="formulario" method="POST" action="/login">
		<?= csrf() ?>
		<div class="formulario__campo">
			<label for="email" class="formulario__label">
				Email
			</label>
			<input class="formulario__input" type="email" name="email" id="email" placeholder="correo@correo.com">
		</div>
		<div class="formulario__campo">
			<label for="password" class="formulario__label">
				Password
			</label>
			<input class="formulario__input" type="password" name="password" id="password" placeholder="Password">
		</div>

		<input type="submit" class="formulario__submit" value="Iniciar Sesión">
		<div class="acciones">
			<a href="/registro" data-scroll="inicio" class="acciones__enlace">¿No tienes cuenta? Registrarse</a>
			<a href="/olvide" data-scroll="inicio" class="acciones__enlace">Olvidé mi contraseña</a>
		</div>
	</form>
</main>