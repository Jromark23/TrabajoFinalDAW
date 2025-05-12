<fieldset class="formulario__fieldset">
	<legend class="formulario__legend">Información del evento</legend>

	<div class="formulario__campo">
		<label for="nombre" class="formulario__label">Nombre</label>
		<input type="text" name="nombre" id="nombre" class="formulario__input"
			placeholder="Nombre del evento" value="<?= $evento->nombre; ?>">
	</div>

	<div class="formulario__campo">
		<label for="descripcion" class="formulario__label">Descripción</label>
		<textarea name="descripcion" id="descripcion" class="formulario__input"
			placeholder="Descripcion del evento" rows="8"><?= $evento->descripcion; ?></textarea>
	</div>

	<div class="formulario__campo">
		<label for="categoria" class="formulario__label">Tipo de evento</label>
		<select class="formulario__select" id="categoria" name="categoria_id">
			<option value="">Seleccionar categoria</option>
			<?php foreach ($categorias as $categoria) { ?>
				<option
					<?= ($evento->categoria_id === $categoria->id) ? 'selected' : '' ?>
						value="<?= $categoria->id; ?>"><?= $categoria->nombre; ?>
				</option>
			<?php } ?>
		</select>
	</div>

	<div class="formulario__campo">
		<label for="dia" class="formulario__label">Días</label>

		<div class="formulario__radio">
			<?php foreach ($dias as $dia) { ?>
				<div>
					<label for="<?= strtolower($dia->nombre); ?>"><?= $dia->nombre; ?></label>

					<input type="radio" id="<?= strtolower($dia->nombre); ?>"
						name="dia" value="<?= $dia->id; ?>">
				</div>
			<?php } ?>
		</div>
		<input type="hidden" name="dia_id" value="">
	</div>

	<div id="horass" class="formulario__campo">
		<label for="hora" class="formulario__label" >Seleccionar hora</label>
		<ul class="horas" id="horas">
			<?php foreach ($horas as $hora) { ?>
				<li data-hora-id="<?= $hora->id; ?>" class="horas__hora horas__hora--disabled"> <?= $hora->hora ?> </li>
			<?php } ?>
		</ul>
		<input type="hidden" name="hora_id" value="">
	</div>
</fieldset>

<fieldset class="formulario__fieldset">
	<legend class="formulario__legend">Información extra</legend>

	<div class="formulario__campo">
		<label for="ponentes" class="formulario__label">Ponente</label>
		<input type="text" name="ponentes" id="ponentes" class="formulario__input"
			placeholder="Buscar ponentes">
	</div>

	<div class="formulario__campo">
		<label for="disponibles" class="formulario__label">Plazas máximas disponibles</label>
		<input type="number" min="1" name="disponibles" id="disponibles" class="formulario__input"
			placeholder="ej. 20" value="<?= $evento->disponibles; ?>">
	</div>

</fieldset>