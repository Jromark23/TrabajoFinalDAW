<main class="registro">
	<h2 class="registro__heading">
		<?= $titulo; ?>
		<p class="registro__descripcion"> Elige el tipo de entrada </p>

	</h2>

	<div class="entradas__grid">
		<div class="entrada">
			<h3 class="entrada__nombre">Acceso virtual</h3>
			<ul class="entrada__lista">
				<li class="entrada__li">Acceso virtual</li>
				<li class="entrada__li">Acceso a los dos días del evento</li>
				<li class="entrada__li">Acceso a los talleres y conferencias</li>
				<li class="entrada__li">Acceso ilimitado a las grabaciones</li>
			</ul>

			<p class="entrada__precio">50€</p>

			<form action="/finalizar/virtual" method="post">
				<input class="entradas__submit" type="submit" value="Inscripcion virtual">
			</form>
		</div>

		<div class="entrada">
			<h3 class="entrada__nombre">Acceso presencial</h3>
			<ul class="entrada__lista">
				<li class="entrada__li">Acceso presencial al evento</li>
				<li class="entrada__li">Acceso a los dos días del evento</li>
				<li class="entrada__li">Acceso a los talleres y conferencias</li>
				<li class="entrada__li">Acceso a ilimitado a las grabaciones</li>
				<li class="entrada__li">Camiseta del evento</li>
				<li class="entrada__li">Comida y bebida</li>
			</ul>

			<p class="entrada__precio">120€</p>
			<form action="/finalizar/presencial" method="post">
				<input class="entradas__submit" type="submit" value="Inscripcion presencial">
			</form>
		</div>

		<div class="entrada">
			<h3 class="entrada__nombre">Acceso básico</h3>
			<ul class="entrada__lista">
				<li class="entrada__li">Acceso virtual limitado</li>
			</ul>

			<p class="entrada__precio">0€</p>
			<form action="/finalizar/basico" method="post">
				<input class="entradas__submit" type="submit" value="Inscripcion básica">
			</form>
		</div>

	</div>
</main>