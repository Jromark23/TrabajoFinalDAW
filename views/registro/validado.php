<main class="pagina">
	<h2 class="pagina__heading"><?= $titulo ?></h2>

	<div class="validado">
		<?php if ($tipo === 'success'): ?>
			<div class="alerta alerta__exito">
				<p><?= $mensaje ?></p>
			</div>
		<?php elseif ($tipo === 'error'): ?>
			<div class="alerta alerta__error">
				<p><?= $mensaje ?></p>
			</div>
		<?php endif; ?>

		<div>
			<a href="/" class="boton">Volver al inicio</a>
		</div>
	</div>
</main>