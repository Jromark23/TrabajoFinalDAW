<div class="evento swiper-slide">
	<p class="evento__hora"><?= $evento->hora->hora ?></p>

	<div class="evento__info">
		<h4 class="evento__nombre"><?= $evento->nombre ?></h4>
		<p class="evento__descripcion"><?= $evento->descripcion ?></p>
		<div class="evento__ponente">
			<picture>
				<source srcset="/public/build/img/speakers/<?= $evento->ponente->imagen; ?>.webp"
					type="image/webp">
				<source srcset="/public/build/img/speakers/<?= $evento->ponente->imagen; ?>.png"
					type="image/png">
				<img class="evento__img" src="/public/build/img/speakers/<?= $evento->ponente->imagen; ?>.png"
					width="200" height="300" alt="Imagen ponente">
			</picture>

			<p class="evento__ponente-nombre">
				<?= $evento->ponente->nombre . " " . $evento->ponente->apellido ?>
			</p>
		</div>
	</div>
</div>

