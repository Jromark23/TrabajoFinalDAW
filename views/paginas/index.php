<?php
include_once __DIR__ . '/eventos.php';
include_once __DIR__ . '/talleres.php';
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
					<source srcset="/src/img/speakers/<?= $ponente->imagen; ?>.webp" type="image/webp">
					<source srcset="/src/img/speakers/<?= $ponente->imagen; ?>.png" type="image/png">
					<img class="ponente__img" src="/src/img/speakers/<?= $ponente->imagen; ?>.png"
						width="200" height="300" alt="Imagen ponente">
				</picture>

				<div class="ponente__info">
					<h4 class="ponente__nombre"> <?= $ponente->nombre . " " . $ponente->apellido ?> </h4>

					<p class="ponente__ciudad"> <?= $ponente->ciudad . ", " . $ponente->pais ?></p>

					<nav class="ponente__rrss">
						<?php $redes = json_decode($ponente->rrss); ?>

						<?php if (!empty($redes->facebook)) { ?>
							<a class="ponente__enlace" href="https://www.facebook.com/<?= $redes->facebook; ?>" target="_blank" rel="noopener noreferrer" aria-label="Facebook">
								<div class="ponente__icono">
									<i class="fa-brands fa-facebook"></i>
								</div>
							</a>
						<?php } ?>
						<?php if (!empty($redes->twitter)) { ?>
							<a class="ponente__enlace" href="https://x.com/<?= $redes->x; ?>" target="_blank" rel="noopener noreferrer" aria-label="X (Twitter)">
								<div class="ponente__icono">
									<i class="fa-brands fa-x-twitter"></i>
								</div>
							</a>
						<?php } ?>
						<?php if (!empty($redes->youtube)) { ?>
							<a class="ponente__enlace" href="https://www.youtube.com/@<?= $redes->youtube; ?>" target="_blank" rel="noopener noreferrer" aria-label="YouTube">
								<div class="ponente__icono">
									<i class="fa-brands fa-youtube"></i>
								</div>
							</a>
						<?php } ?>
						<?php if (!empty($redes->instagram)) { ?>
							<a class="ponente__enlace" href="https://www.instagram.com/<?= $redes->instagram; ?>" target="_blank" rel="noopener noreferrer" aria-label="Instagram">
								<div class="ponente__icono">
									<i class="fa-brands fa-instagram"></i>
								</div>
							</a>
						<?php } ?>
						<?php if (!empty($redes->tiktok)) { ?>
							<a class="ponente__enlace" href="https://www.tiktok.com/@<?= $redes->tiktok; ?>" target="_blank" rel="noopener noreferrer" aria-label="TikTok">
								<div class="ponente__icono">
									<i class="fa-brands fa-tiktok"></i>
								</div>
							</a>
						<?php } ?>
						<?php if (!empty($redes->github)) { ?>
							<a class="ponente__enlace" href="https://github.com/<?= $redes->github; ?>" target="_blank" rel="noopener noreferrer" aria-label="GitHub">
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
<h2 class="pases__heading">Donde estamos ubicados</h2>
<div id="map" class="mapa"></div>

