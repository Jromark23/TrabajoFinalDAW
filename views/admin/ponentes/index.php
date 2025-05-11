<h2 class="dashboard__heading"> <?php echo $titulo; ?> </h2>

<div class="dashboard__contenedor-boton">
	
	<a href="/admin/ponentes/crear" class="dashboard__boton">
		<i class="fa-solid fa-circle-plus"></i>
		Añadir ponente
	</a>
		<!--  iNPUTS PARA LA BUSQUEDA-->
		<p>  <---- ZONA DE BUSQUEDA</p>
	<!--  -->
</div>

<div class="dashboard__contenedor">
	<?php if (!empty($ponentes)) { ?>
		<div class="tabla-scroll">
		<table class="table">
			<thead class="table__thead">
				<tr>
					<th scope="col" class="table__th">Nombre</th>
					<th scope="col" class="table__th">Ciudad</th>
					<th scope="col" class="table__th"></th>
				</tr>
			</thead>

			<tbody class="table__tbody">
				<?php foreach ($ponentes as $ponente) { ?>
					<tr class="table__tr">
						<td class="table__td">
							<?php echo $ponente->nombre . " " . $ponente->apellido ?>
						</td>
						<td class="table__td">
							<?php echo $ponente->ciudad . ", " . $ponente->pais ?>
						</td>
						<td class="table__td--acciones">
							<a class="table__accion table__accion--editar" href="/admin/ponentes/editar?id=<?php echo $ponente->id; ?>">
								<i class="fa-solid fa-pen-to-square"></i>
								Editar
							</a>

							<form action="/admin/ponentes/eliminar" method="post" class="table__formulario">
								<input type="hidden" name="id" value="<?php echo $ponente->id; ?>">
								<button class="table__accion table__accion--eliminar" type="submit">
									<i class="fa-solid fa-trash"></i>
									Eliminar
								</button>
							</form>
						</td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
		</div>
	<?php } else { ?>
		<p class="text-center">Aún no hay ponentes</p>
	<?php }  ?>
</div>

<?php echo $paginacion; ?>