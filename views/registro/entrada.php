<main class="pagina">
	<h2 class="pagina__heading">
		<?= $titulo; ?>
	</h2>
	<p class="pagina__descripcion"> Aquí tienes tu entrada. Guardala bien, o compartela por RRSS </p>


	<div class="tickets">
		<div class="ticket ticket--<?= strtolower($registro->paquete->nombre); ?> ticket--acceso">
			<div class="ticket__contenido">
				<h4 class="ticket__logo">&#60;&nbsp;&nbsp;Congrexia Events&nbsp;&nbsp;/></h4>
				<div class="ticket__grid">
					<div>
					<p class="ticket__plan">Acceso <?= $registro->paquete->nombre ?></p>
					<p class="ticket__nombre">Nombre:<br><?= $registro->usuario->nombre . " " . $registro->usuario->apellido ?></p>
					<p class="ticket__codigo"><?= '#' . $registro->token ?></p>
					</div>
					<!-- QR -->
					<div class="ticket__qr">
					<img 
						src="<?= $qrDataUri ?>"
						alt="Código QR para validar la entrada"
						/>
					<p> Escanea este QR al llegar al evento </p>
					</div>
				</div>
			</div>

		</div>
	</div>

</main>