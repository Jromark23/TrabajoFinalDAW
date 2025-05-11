<main class="auth">
	<h2 class="auth__heading">
		<?php echo $titulo; ?>
	</h2>
	<p class="auth__texto"> Ingresa tu nueva contraseña </p>

	<?php require_once __DIR__ . '/../templates/alertas.php'; 	?>

	<?php if ($token_valido) { 		?>

		<form class="formulario" method="post">
			<div class="formulario__campo">
				<label for="password" class="formulario__label">
					Nueva contraseña
				</label>
				<input class="formulario__input" type="password" name="password" id="password" placeholder="Nueva contraseña">
			</div>

			<input type="submit" class="formulario__submit" value="Guardar contraseña">
		</form>

	<?php } ?>

	<div class="acciones">
		<a href="/login" class="acciones__enlace">Iniciar sesión</a>
		<a href="/registro" class="acciones__enlace">¿No tienes cuenta? Registrarse</a>
	</div>
</main>