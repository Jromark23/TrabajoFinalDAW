<h2 class="dashboard__heading"> <?= $titulo; ?> </h2>

<div class="dashboard__contenedor-boton">

	<a href="/admin/eventos/crear" class="dashboard__boton">
		<i class="fa-solid fa-circle-plus"></i>
		Añadir evento
	</a>
</div>

<div class="dashboard__contenedor">
	<?php if (!empty($eventos)) { ?>
		<div class="tabla-scroll">
			<table class="table">
				<thead class="table__thead">
					<tr>
						<th scope="col" class="table__th">Evento</th>
						<th scope="col" class="table__th">Categoria</th>
						<th scope="col" class="table__th">Día y hora</th>
						<th scope="col" class="table__th">Ponente</th>
						<th scope="col" class="table__th"></th>
					</tr>
				</thead>

				<tbody class="table__tbody">
					<?php foreach ($eventos as $evento) { ?>
						<tr class="table__tr">
							<td class="table__td">
								<?= $evento->nombre ?>
							</td>
							<td class="table__td">
								<?= $evento->categoria->nombre ?>
							</td>
							<td class="table__td">
								<?= $evento->dia->nombre . " " . $evento->hora->hora ?>
							</td>
							<td class="table__td">
								<?= $evento->ponente->nombre . " " . $evento->ponente->apellido ?>
							</td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
	<?php } else { ?>
		<p class="text-center">Aún no hay eventos</p>
	<?php }  ?>


	<?= $paginacion; ?>
</div>