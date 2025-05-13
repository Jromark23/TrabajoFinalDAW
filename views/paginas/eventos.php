<main class="agenda">
	<h2 class="agenda__heading"> <?= $titulo; ?> </h2>
	<p class="agenda__descripcion">
		Talleres y conferencias guiados por expertos.
	</p>


	<div class="eventos">
		<h3 class="eventos__heading">&lt;Conferencias/> </h3>
		<p class="eventos__fecha">Viernes 14 de junio</p>

		<div class="eventos__lista slider swiper">
			<div class="swiper-wrapper">
				<?php foreach ($eventos['conferencia_v'] as $evento) {
					include	__DIR__ . '../../templates/evento.php';
				} ?>
			</div>
			<!-- Paginación (bolitas) -->
			<div class="swiper-pagination"></div>

			<!-- Botones de navegación -->
			<div class="swiper-button-prev"></div>
			<div class="swiper-button-next"></div>
		</div>

		<p class="eventos__fecha">Sabado 15 de junio</p>

		<div class="eventos__lista slider swiper">
			<div class="swiper-wrapper">
				<?php foreach ($eventos['conferencia_s'] as $evento) { 
					include	__DIR__ . '../../templates/evento.php';
				} ?>
			</div>
			<!-- Paginación (bolitas) -->
			<div class="swiper-pagination"></div>

			<!-- Botones de navegación -->
			<div class="swiper-button-prev"></div>
			<div class="swiper-button-next"></div>
		</div>
	</div>

	<div class="eventos eventos--talleres">
		<h3 class="eventos__heading--talleres">&lt;Talleres/> </h3>
		<p class="eventos__fecha">Viernes 14 de junio</p>

		<div class="eventos__lista slider swiper">
			<div class="swiper-wrapper">
				<?php foreach ($eventos['taller_v'] as $evento) {
					include	__DIR__ . '../../templates/evento.php';
				}
				?>
			</div>
			<!-- Paginación (bolitas) -->
			<div class="swiper-pagination"></div>

			<!-- Botones de navegación -->
			<div class="swiper-button-prev"></div>
			<div class="swiper-button-next"></div>
		</div>

		<p class="eventos__fecha">Sabado 15 de junio</p>

		<div class="eventos__lista slider swiper">
			<div class="swiper-wrapper">
				<?php foreach ($eventos['taller_s'] as $evento) { 
					include	__DIR__ . '../../templates/evento.php';
				} ?>
			</div>
			<!-- Paginación (bolitas) -->
			<div class="swiper-pagination"></div>

			<!-- Botones de navegación -->
			<div class="swiper-button-prev"></div>
			<div class="swiper-button-next"></div>
		</div>
	</div>
</main>