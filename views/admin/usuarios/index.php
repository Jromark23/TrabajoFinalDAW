<h2 class="dashboard__heading"> <?= $titulo; ?> </h2>


<div class="dashboard__contenedor">
	<?php if (!empty($registros)) { ?>
		<div class="tabla-scroll">
			<table class="table">
				<thead class="table__thead">
					<tr>
						<th scope="col" class="table__th">Nombre</th>
						<th scope="col" class="table__th">Email</th>
						<th scope="col" class="table__th">Plan</th>
					</tr>
				</thead>

				<tbody class="table__tbody">
					<?php foreach ($registros as $registro) { ?>
						<tr class="table__tr">
							<td class="table__td">
								<?= $registro->usuario->nombre . " " .  $registro->usuario->apellido?>
							</td>
							<td class="table__td">
								<?= $registro->usuario->email ?>
							</td>
							<td class="table__td">
								<?= $registro->paquete->nombre ?>
							</td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
	<?php } else { ?>
		<p class="text-center">Aún no hay registros</p>
	<?php }  ?>
</div>

<?= $paginacion; ?>