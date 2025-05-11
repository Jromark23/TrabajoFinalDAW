<fieldset class="formulario__fieldset">
	<legend class="formulario__legend">Información del evento</legend>

	<div class="formulario__campo">
		<label for="nombre" class="formulario__label">Nombre</label>
		<input type="text" name="nombre" id="nombre" class="formulario__input"
			placeholder="Nombre del evento">
	</div>

	<div class="formulario__campo">
		<label for="descripcion" class="formulario__label">Descripción</label>
		<textarea name="descripcion" id="descripcion" class="formulario__input"
			placeholder="Descripcion del evento" rows="8"></textarea>
	</div>

	<div class="formulario__campo">
		<label for="categoria" class="formulario__label">Categoria</label>
		<select class="formulario__select" id="categoria" name="categoria_id">
			<option value="">Seleccionar categoria</option>
			<?php foreach ($categorias as $categoria) { ?>
				<option value="<?php echo $categoria->id; ?>"><?php echo $categoria->nombre; ?></option>
			<?php } ?>
		</select>
	</div>

	<div class="formulario__campo">
		<label for="dia" class="formulario__label">Días</label>

		<div class="formulario__radio">
			<?php foreach ($dias as $dia) { ?>
				<div>
					<label for="<?php echo strtolower($dia->nombre); ?>"><?php echo $dia->nombre; ?></label>

					<input type="radio" id="<?php echo strtolower($dia->nombre); ?>"
						value="<?php echo $dia->id; ?>">
				</div>
			<?php } ?>
		</div>
	</div>

	<div id="horas" class="formulario__campo">
		<label for="hora" class="formulario__label">Seleccionar hora</label>
		<ul class="horas">
			<?php foreach($horas as $hora) { ?>
				<li class="horas__hora"> <?php echo $hora->hora ?> </li>
			<?php } ?>
		</ul>
	</div>


</fieldset>