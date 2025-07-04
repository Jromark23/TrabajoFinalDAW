<h2 class="dashboard__heading"> <?= $titulo; ?> </h2>

<div class="dashboard__contenedor-boton">
	<a href="/admin/eventos" class="dashboard__boton">
		<i class="fa-solid fa-circle-arrow-left"></i>
		Volver
	</a>
</div>

<div class="dashboard__formulario">
	<?php include_once __DIR__ . '/../../templates/alertas.php' ?>

	<form action="/admin/eventos/crear" method="post" class="formulario">
		<?= csrf() ?>

		<?php include_once __DIR__ . '/formulario.php' ?>


		<input class="formulario__submit formulario__submit--registrar" type="submit" value="Registrar evento">
	</form>
</div>