<div class="evento">
	<p class="evento__hora"><?= $evento->hora->hora ?></p>

	<div class="evento__info">
		<h4 class="evento__nombre"><?= $evento->nombre ?></h4>
		<p class="evento__descripcion"><?= $evento->descripcion ?></p>
		<div class="evento__ponente">
			<picture>
				<source srcset="/img/speakers/<?= $evento->ponente->imagen; ?>.webp"
					type="image/webp">
				<source srcset="/img/speakers/<?= $evento->ponente->imagen; ?>.png"
					type="image/png">
				<img class="evento__img" src="/img/speakers/<?= $evento->ponente->imagen; ?>.png"
					width="200" height="300" alt="Imagen ponente">
			</picture>

			<p class="evento__ponente-nombre">
				<?= $evento->ponente->nombre . " " . $evento->ponente->apellido ?>
			</p>
		</div>
		<p class="registro__disponibles"><?= $evento->disponibles  . " Asientos disponibles" ?></p>
		<button type="button" data-id="<?= $evento->id ?>" class="evento__boton"
			<?= ($evento->disponibles === "0") ? 'disabled' : '' ?>
		>
			<?= ($evento->disponibles !== "0") ? 'Agregar' : 'Agotado' ?>
		</button>
	</div>
</div>

