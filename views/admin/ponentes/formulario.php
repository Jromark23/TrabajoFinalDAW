<fieldset class="formulario__fieldset">
	<legend class="formulario__legend">Información Personal</legend>

	<div class="formulario__campo">
		<label for="nombre" class="formulario__label">Nombre</label>
		<input type="text" name="nombre" id="nombre" class="formulario__input"
			placeholder="Nombre del ponente" value="<?= $ponente->nombre ?? '' ?>">
	</div>

	<div class="formulario__campo">
		<label for="apellido" class="formulario__label">Apellidos</label>
		<input type="text" name="apellido" id="apellido" class="formulario__input"
			placeholder="Apellidos del ponente" value="<?= $ponente->apellido ?? '' ?>">
	</div>

	<div class="formulario__campo">
		<label for="ciudad" class="formulario__label">Ciudad</label>
		<input type="text" name="ciudad" id="ciudad" class="formulario__input"
			placeholder="Ciudad del ponente" value="<?= $ponente->ciudad ?? '' ?>">
	</div>

	<div class="formulario__campo">
		<label for="pais" class="formulario__label">Pais</label>
		<input type="text" name="pais" id="pais" class="formulario__input"
			placeholder="Pais del ponente" value="<?= $ponente->pais ?? '' ?>">
	</div>
	<div class="formulario__campo">
		<label for="imagen" class="formulario__label">Imagen</label>
		<input type="file" name="imagen" id="imagen" class="formulario__input formulario__input--file">
	</div>

	<?php if (isset($ponente->img_actual)) { ?>
		<p class="formulario__texto">Imagen actual</p>
		<div class="formulario__imagen">
			<!-- picture nos permite mejorar el rendimiento eligiendo entre varias opciones, y pudiendo priorizar webp -->
			<picture>
				<source srcset="<?= $_ENV['HOST'] . '/build/img/speakers/' . $ponente->imagen; ?>.webp" 
					type="image/webp">
				<source srcset="<?= $_ENV['HOST'] . '/build/img/speakers/' . $ponente->imagen; ?>.png" 
					type="image/png">
				<img src="<?= $_ENV['HOST'] . '/build/img/speakers/' . $ponente->imagen; ?>.png" alt="Imagen ponente">
			</picture>
		</div>
	<?php } ?>
</fieldset>

<!-- Info extra -->
<fieldset class="formulario__fieldset">
	<legend class="formulario__legend">Información Extra</legend>

	<div class="formulario__campo">
		<label for="tags_input" class="formulario__label">Conocimientos (pulsa enter para guardar)</label>
		<input type="text" name="tags_input" id="tags_input"
			class="formulario__input" placeholder="Ej. Node.js, PHP, Js">
	</div>

	<div class="formulario__listado" id="tags"></div>
	<input type="hidden" name="tags" value="<?= $ponente->tags ?? ''; ?> ">
</fieldset>


<!-- RRSS -->
<fieldset class="formulario__fieldset">
	<legend class="formulario__legend">Redes Sociales</legend>

	<div class="formulario__campo">
		<div class="formulario__contenedor-icono">
			<div class="formulario__icono">
				<i class="fa-brands fa-facebook"></i>
			</div>

			<!-- rrss[nombre] nos crea su propia key en el array -->
			<input type="text" name="rrss[facebook]"
				class="formulario__input--rrss"
				placeholder="Facebook" value="<?= $rrss->facebook ?? '' ?>">
		</div>
	</div>

	<div class="formulario__campo">
		<div class="formulario__contenedor-icono">
			<div class="formulario__icono">
				<i class="fa-brands fa-x-twitter"></i>
			</div>

			<input type="text" name="rrss[x]"
				class="formulario__input--rrss"
				placeholder="X" value="<?= $rrss->x ?? '' ?>">
		</div>
	</div>

	<div class="formulario__campo">
		<div class="formulario__contenedor-icono">
			<div class="formulario__icono">
				<i class="fa-brands fa-instagram"></i>
			</div>

			<input type="text" name="rrss[instagram]"
				class="formulario__input--rrss"
				placeholder="Instagram" value="<?= $rrss->instagram ?? '' ?>">
		</div>
	</div>

	<div class="formulario__campo">
		<div class="formulario__contenedor-icono">
			<div class="formulario__icono">
				<i class="fa-brands fa-youtube"></i>
			</div>

			<input type="text" name="rrss[youtube]"
				class="formulario__input--rrss"
				placeholder="Youtube" value="<?= $rrss->youtube ?? '' ?>">
		</div>
	</div>

	<div class="formulario__campo">
		<div class="formulario__contenedor-icono">
			<div class="formulario__icono">
				<i class="fa-brands fa-tiktok"></i>
			</div>

			<input type="text" name="rrss[tiktok]"
				class="formulario__input--rrss"
				placeholder="Tiktok" value="<?= $rrss->tiktok ?? '' ?>">
		</div>
	</div>

	<div class="formulario__campo">
		<div class="formulario__contenedor-icono">
			<div class="formulario__icono">
				<i class="fa-brands fa-github"></i>
			</div>

			<input type="text" name="rrss[github]"
				class="formulario__input--rrss"
				placeholder="Github" value="<?= $rrss->github ?? '' ?>">
		</div>
	</div>

</fieldset>