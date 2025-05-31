<main class="auth">
	<h2 class="auth__heading" id="reg">
		<?= $titulo; ?>
	</h2>
	<p class="auth__texto">
		Regístrate en el campus
	</p>

	<?php
		require_once __DIR__ . '/../templates/alertas.php';
	?>
	
	<form class="formulario" method="post" action="/registro">
		<?= csrf() ?>
		<div class="formulario__campo">
			<label for="nombre" class="formulario__label">
				Nombre
			</label>
			<input class="formulario__input" type="text" name="nombre" id="nombre" placeholder="Ingresa tu nombre"
			value="<?= $usuario->nombre?>">
		</div>

		<div class="formulario__campo">
			<label for="apellido" class="formulario__label">
				Apellido
			</label>
			<input class="formulario__input" type="text" name="apellido" id="apellido" placeholder="Ingresa tu apellido"
			value="<?= $usuario->apellido?>">
		</div>

		<div class="formulario__campo">
			<label for="email" class="formulario__label">
				Email
			</label>
			<input class="formulario__input" type="email" name="email" id="email" placeholder="correo@correo.com"
			value="<?= $usuario->email?>">
		</div>

		<div class="formulario__campo">
			<label for="password" class="formulario__label">
				Password
			</label>
			<input class="formulario__input" type="password" name="password" id="password" placeholder="Password">
		</div>

		<div class="formulario__campo">
			<label for="password2" class="formulario__label">
				Password
			</label>
			<input class="formulario__input" type="password" name="password2" id="password2" placeholder="Password">
		</div>

		<input type="submit" class="formulario__submit" value="Crear cuenta">
		<div class="acciones">
			<a href="/login" data-scroll="inicio" class="acciones__enlace">¿Ya tienes cuenta? Iniciar sesión</a>
			<a href="/olvide" data-scroll="inicio" class="acciones__enlace">Olvidé mi contraseña</a>
		</div>
	</form>
</main>