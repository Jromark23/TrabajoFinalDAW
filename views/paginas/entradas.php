<main class="entradas">
	<h2 class="entradas__heading" id="tipo"> <?= $titulo; ?> </h2>
	<p class="entradas__descripcion">
		Elige tu tipo de entrada
	</p>

	<div class="entradas__grid">
		<div class="entrada">
			<h3 class="entrada__nombre">Paquete presencial</h3>
			<ul class="entrada__lista">
				<li class="entrada__li">Acceso presencial al evento</li>
				<li class="entrada__li">Acceso hasta 5 conferencias o talleres</li>
				<li class="entrada__li">Acceso a ilimitado a las grabaciones</li>
				<li class="entrada__li">Camiseta del evento</li>
				<li class="entrada__li">Comida y bebida</li>
			</ul>

			<p class="entrada__precio">70€</p>
		</div>

		<div class="entrada">
			<h3 class="entrada__nombre">Paquete premium</h3>
			<ul class="entrada__lista">
				<li class="entrada__li">Acceso presencial al evento</li>
				<li class="entrada__li">Acceso ilimitado los dos días del evento</li>
				<li class="entrada__li">Acceso a todos los talleres y conferencias</li>
				<li class="entrada__li">Acceso ilimitado a las grabaciones</li>
				<li class="entrada__li">Regalo especial y acceso preferente</li>
				<li class="entrada__li">Comida y bebida</li>
			</ul>

			<p class="entrada__precio">200€</p>
		</div>


		<div class="entrada">
			<h3 class="entrada__nombre">Acceso básico</h3>
			<ul class="entrada__lista">
				<li class="entrada__li">Acceso al streaming del evento</li>
			</ul>

			<p class="entrada__precio">0€</p>
		</div>

	</div>
	<div class="entradas_ppp">
		<a href="/registro" data-scroll="inicio" class="entradas__boton">Comprar entradas</a>
	</div>
</main>