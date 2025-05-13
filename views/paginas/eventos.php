<main class="agenda">
	<h2 class="agenda__heading"> <?= $titulo; ?> </h2>
	<p class="agenda__descripcion">
		Talleres y conferencias guiados por expertos.
	</p>


	<div class="eventos">
		<h3 class="eventos__heading">&lt;Conferencias/> </h3>
		<p class="eventos__fecha">Viernes 14 de junio</p>

		<div class="eventos__lista">
			<?php foreach ($eventos['conferencia_v'] as $evento) { ?>
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
					</div>
				</div>
			<?php } ?>
		</div>

		<p class="eventos__fecha">Sabado 15 de junio</p>

		<div class="eventos__lista">
			<?php foreach ($eventos['conferencia_s'] as $evento) { ?>
				<div class="evento">
					<p class="evento__hora"><?= $evento->hora->hora ?></p>

					<div class="evento__info">
						<h4 class="evento__nombre"><?= $evento->nombre ?></h4>
						<p class="evento__info"><?= $evento->descripcion ?></p>
					</div>
					<div class="evento_autor">
						<picture>
							<source srcset="/img/speakers/<?= $evento->ponente->imagen; ?>.webp"
								type="image/webp">
							<source srcset="/img/speakers/<?= $evento->ponente->imagen; ?>.png"
								type="image/png">
							<img src="/img/speakers/<?= $evento->ponente->imagen; ?>.png" alt="Imagen ponente">
						</picture>

						<p class="evento__autor-nombre">
							<?= $evento->ponente->nombre . " " . $evento->ponente->apellido ?>
						</p>
					</div>

				</div>
			<?php } ?>
		</div>
	</div>

	<div class="eventos eventos">
		<h3 class="eventos__heading--talleres">&lt;Talleres/> </h3>
		<p class="eventos__fecha">Viernes 14 de junio</p>

		<div class="eventos__lista">
			<?php foreach ($eventos['taller_v'] as $evento) { ?>
				<div class="evento">
					<p class="evento__hora"><?= $evento->hora->hora ?></p>

					<div class="evento__info">
						<h4 class="evento__nombre"><?= $evento->nombre ?></h4>
						<p class="evento__info"><?= $evento->descripcion ?></p>
					</div>
					<div class="evento_autor">
						<picture>
							<source srcset="/img/speakers/<?= $evento->ponente->imagen; ?>.webp"
								type="image/webp">
							<source srcset="/img/speakers/<?= $evento->ponente->imagen; ?>.png"
								type="image/png">
							<img src="/img/speakers/<?= $evento->ponente->imagen; ?>.png" alt="Imagen ponente">
						</picture>

						<p class="evento__autor-nombre">
							<?= $evento->ponente->nombre . " " . $evento->ponente->apellido ?>
						</p>
					</div>

				</div>
			<?php } ?>
		</div>

		<p class="eventos__fecha">Sabado 15 de junio</p>

		<div class="eventos__lista">
			<?php foreach ($eventos['taller_s'] as $evento) { ?>
				<div class="evento">
					<p class="evento__hora"><?= $evento->hora->hora ?></p>

					<div class="evento__info">
						<h4 class="evento__nombre"><?= $evento->nombre ?></h4>
						<p class="evento__info"><?= $evento->descripcion ?></p>
					</div>
					<div class="evento_autor">
						<picture>
							<source srcset="/img/speakers/<?= $evento->ponente->imagen; ?>.webp"
								type="image/webp">
							<source srcset="/img/speakers/<?= $evento->ponente->imagen; ?>.png"
								type="image/png">
							<img src="/img/speakers/<?= $evento->ponente->imagen; ?>.png" alt="Imagen ponente">
						</picture>

						<p class="evento__autor-nombre">
							<?= $evento->ponente->nombre . " " . $evento->ponente->apellido ?>
						</p>
					</div>

				</div>
			<?php } ?>
		</div>
	</div>
</main>