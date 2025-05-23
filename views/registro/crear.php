<main class="registro">
	<h2 class="registro__heading">
		<?= $titulo; ?>
	</h2>
	<p class="registro__descripcion"> Elige el tipo de entrada </p>


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
			<div id="paypal-button-container-virtual"></div>
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
			<div id="paypal-button-container-presencial"></div>



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

<script>
	// Boton de presencial 
	paypal.Buttons({
		createOrder: function(data, actions) {
			return actions.order.create({
				purchase_units: [{
					description: "1",
					amount: {
						currency_code: "EUR",
						value: "120.00"
					}
				}]
			});
		},
		onApprove: function(data, actions) {
			return actions.order.capture().then(function(details) {
				const datos = new FormData();
				// Recogemos el array que nos devuelve paypal con la informacion y cogemos descripcion y el pago_id
				datos.append('paquete_id', details.purchase_units[0].description);
				datos.append('pago_id', details.purchase_units[0].payments.captures[0].id);

				//Mandamos al back por post
				fetch('/finalizar/pagar', {
						method: 'POST',
						body: datos
					})
					.then(respuesta => respuesta.json())
					.then(resultado => {
						if (resultado.resultado) {
							actions.redirect('http://localhost:3000/finalizar/conferencias');
						}
					})
			});
		},
		onError: function(err) {
			console.error(err);
			alert('Error al procesar el pago.');
		}
	}).render('#paypal-button-container-presencial');


	paypal.Buttons({
		createOrder: function(data, actions) {
			return actions.order.create({
				purchase_units: [{
					description: "2",
					amount: {
						currency_code: "EUR",
						value: "50.00"
					}
				}]
			});
		},
		onApprove: function(data, actions) {
			return actions.order.capture().then(function(details) {
				const datos = new FormData();
				datos.append('paquete_id', details.purchase_units[0].description);
				datos.append('pago_id', details.purchase_units[0].payments.captures[0].id);

				//Mandamos al back por post
				fetch('/finalizar/pagar', {
						method: 'POST',
						body: datos
					})
					.then(respuesta => respuesta.json())
					.then(resultado => {
						if (resultado.resultado) {
							actions.redirect('http://localhost:3000/finalizar/conferencias');
						}
					})
			});
		},
		onError: function(err) {
			console.error(err);
			alert('Error al procesar el pago.');
		}
	}).render('#paypal-button-container-virtual');
</script>