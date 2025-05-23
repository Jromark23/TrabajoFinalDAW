<h2 class="dashboard__heading"> <?= $titulo; ?> </h2>

<main class="bloques">
	<div class="bloques__grid">
		<div class="bloque">
			<h3 class="bloque__heading">Últimos registrados</h3>

			<?php foreach ($registros as $registro) { ?>
				<div class="bloque__contenido bloque__flex">
					<p class="bloque__texto">
						<?= $registro->usuario->nombre . " " . $registro->usuario->apellido?>
					</p>
					<p class="bloque__texto">
						<?= $registro->paquete->nombre?>
					</p>
				</div>
			<?php } ?>
		</div>

		<div class="bloque">
			<h3 class="bloque__heading">Ingresos totales</h3>
			<p class="bloque__texto--cantidad">
				<?= $total ?>€
			</p>
		</div>

		<div class="bloque">
			<h3 class="bloque__heading">Eventos mas ocupados</h3>

			<?php foreach ($disponibles as $evento) { ?>
				<div class="bloque__contenido">
					<p class="bloque__texto">
						<?= $evento->nombre . " - " . $evento->disponibles ?>
					</p>
				</div>
			<?php } ?>
			</p>
		</div>

		<div class="bloque">
			<h3 class="bloque__heading">Eventos mas disponibles</h3>
			<?php foreach ($ocupados as $evento) { ?>
				<div class="bloque__contenido">
					<p class="bloque__texto">
						<?= $evento->nombre . " - " . $evento->disponibles ?>
					</p>
				</div>
			<?php } ?>
			</p>
		</div>
	</div>
</main>