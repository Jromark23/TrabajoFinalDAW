<?php
	include_once __DIR__ . '/eventos.php';
?>

<section class="resumen">
	<div class="resumen__grid">
		<div <?= animacion_aos(); ?> class="resumen__bloque">
			<p class="resumen__texto--numero"><?= $ponentes_total ?></p>
			<p class="resumen__texto">Ponentes</p>
		</div>
		<div <?= animacion_aos(); ?> class="resumen__bloque">
			<p class="resumen__texto--numero"><?= $conferencias_total ?></p>
			<p class="resumen__texto">Conferencias</p>
		</div>
		<div <?= animacion_aos(); ?> class="resumen__bloque">
			<p class="resumen__texto--numero"><?= $talleres_total ?></p>
			<p class="resumen__texto">Talleres</p>
		</div>
		<div <?= animacion_aos(); ?> class="resumen__bloque">
			<p class="resumen__texto--numero">500</p>
			<p class="resumen__texto">Asistentes</p>
		</div>
	</div>
</section>

<section class="ponentes">
	<h2 class="ponentes__heading"> Ponentes </h2>
	<p class="ponentes__descripcion">
		Conoce a nuestros ponentes
	</p>
	<div class="ponentes__grid">
		<?php foreach ($ponentes as $ponente) { ?>
			<div <?= animacion_aos(); ?> class="ponente">
				<picture>
					<source srcset="/img/speakers/<?= $ponente->imagen; ?>.webp" type="image/webp">
					<source srcset="/img/speakers/<?= $ponente->imagen; ?>.png" type="image/png">
					<img class="ponente__img" src="/img/speakers/<?= $ponente->imagen; ?>.png"
						width="200" height="300" alt="Imagen ponente">
				</picture>

				<div class="ponente__info">
					<h4 class="ponente__nombre"> <?= $ponente->nombre . " " . $ponente->apellido ?> </h4>

					<p class="ponente__ciudad"> <?= $ponente->ciudad . ", " . $ponente->pais ?></p>

					<nav class="ponente__rrss">
						<?php $redes = json_decode($ponente->rrss); ?>

						<?php if (!empty($redes->facebook)) { ?>
							<a class="ponente__enlace" href="<?= $redes->facebook; ?>" target="_blank" rel="noopener noreferrer" aria-label="Facebook">
								<div class="ponente__icono">
									<i class="fa-brands fa-facebook"></i>
								</div>
							</a>
						<?php } ?>
						<?php if (!empty($redes->twitter)) { ?>
							<a class="ponente__enlace" href="<?= $redes->x; ?>" target="_blank" rel="noopener noreferrer" aria-label="X (Twitter)">
								<div class="ponente__icono">
									<i class="fa-brands fa-x-twitter"></i>
								</div>
							</a>
						<?php } ?>
						<?php if (!empty($redes->youtube)) { ?>
							<a class="ponente__enlace" href="<?= $redes->youtube; ?>" target="_blank" rel="noopener noreferrer" aria-label="YouTube">
								<div class="ponente__icono">
									<i class="fa-brands fa-youtube"></i>
								</div>
							</a>
						<?php } ?>
						<?php if (!empty($redes->instagram)) { ?>
							<a class="ponente__enlace" href="<?= $redes->instagram; ?>" target="_blank" rel="noopener noreferrer" aria-label="Instagram">
								<div class="ponente__icono">
									<i class="fa-brands fa-instagram"></i>
								</div>
							</a>
						<?php } ?>
						<?php if (!empty($redes->tiktok)) { ?>
							<a class="ponente__enlace" href="<?= $redes->tiktok; ?>" target="_blank" rel="noopener noreferrer" aria-label="TikTok">
								<div class="ponente__icono">
									<i class="fa-brands fa-tiktok"></i>
								</div>
							</a>
						<?php } ?>
						<?php if (!empty($redes->github)) { ?>
							<a class="ponente__enlace" href="<?= $redes->github; ?>" target="_blank" rel="noopener noreferrer" aria-label="GitHub">
								<div class="ponente__icono">
									<i class="fa-brands fa-github"></i>
								</div>
							</a>
						<?php } ?>
					</nav>

					<ul class="ponente__tags">
						<?php $tags = explode(',', $ponente->tags);
						foreach ($tags as $tag) { ?>
							<li class="ponente__tag">
								<?= $tag ?>
							</li>
						<?php } ?>
					</ul>
				</div>
			</div>
		<?php } ?>
	</div>
</section>

<!-- Mapa de localización -->
<div id="map" class="mapa"></div>

<section class="pases">
	<h2 class="pases__heading">Entradas y precios</h2>
	<p class="pases__descripcion">Precios</p>

	<div class="pases__grid">
		<div <?= animacion_aos(); ?> class="pase pase--presencial">
			<h4 class="pase__logo">&#60ProyectoFinal /></h4>
			<p class="pase__tipo">Presencial</p>
			<p class="pase__precio">120€</p>
		</div>

		<div <?= animacion_aos(); ?> class="pase pase--virtual">
			<h4 class="pase__logo">&#60ProyectoFinal /></h4>
			<p class="pase__tipo">Virtual</p>
			<p class="pase__precio">50€</p>
		</div>

		<div <?= animacion_aos(); ?> class="pase pase--gratis">
			<h4 class="pase__logo">&#60ProyectoFinal /></h4>
			<p class="pase__tipo">Básico</p>
			<p class="pase__precio">0€</p>
		</div>
	</div>

	<div class="pase__contenedor">
		<a class="pase__enlace" href="/entradas">Ver entradas</a>
	</div>
</section>