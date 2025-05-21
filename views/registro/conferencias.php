<h2 class="pagina__heading">
	<?= $titulo; ?>
</h2>
<p class="pagina__descripcion"> Elige hasta 5 eventos </p>

<div class="eventos-registro">
	<main class="eventos-registro__listado">
		<h3 class="eventos-registro__heading--conferencias">&lt;Conferencias/> </h3>
		<p class="eventos-registro__fecha">Viernes 14 de junio</p>

		<div class="eventos-registro__grid">
			<?php foreach ($eventos['conferencia_v'] as $evento) {
				include	__DIR__ . '/evento.php';
			} ?>
		</div>

		<p class="eventos-registro__fecha">Sabado 15 de junio</p>
		<div class="eventos-registro__grid">
			<?php foreach ($eventos['conferencia_s'] as $evento) {
				include	__DIR__ . '/evento.php';
			} ?>
		</div>

		<h3 class="eventos-registro__heading--talleres">&lt;Talleres/></h3>
		<p class="eventos-registro__fecha">Viernes 14 de junio</p>
		<div class="eventos-registro__grid eventos--talleres">
			<?php foreach ($eventos['taller_v'] as $evento) {
				include	__DIR__ . '/evento.php';
			}	?>
		</div>

		<p class="eventos-registro__fecha">Sabado 15 de junio</p>
		<div class="eventos-registro__grid eventos--talleres">
			<?php foreach ($eventos['taller_s'] as $evento) {
				include	__DIR__ . '/evento.php';
			} ?>
		</div>


	</main>

	<aside class="registro">
		<h2 class="registro__heading">
			Eventos seleccionados
		</h2>
		<p>Seleccione hasta 5 eventos</p>

		<div id="registro-carro" class="registro__carro">

		</div>
	</aside>

</div>