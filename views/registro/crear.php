<main class="registro">
	<h2 class="registro__heading">
		<?= $titulo; ?>
	</h2>
	<p class="registro__descripcion"> Elige el tipo de entrada </p>


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
			<div id="paypal-button-container-presencial"></div>
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
			<div id="paypal-button-container-virtual"></div>
		</div>


		<div class="entrada">
			<h3 class="entrada__nombre">Paquete básico</h3>
			<ul class="entrada__lista">
				<li class="entrada__li">Acceso al streaming del evento</li>
			</ul>

			<p class="entrada__precio">0€</p>
			<form action="/finalizar/basico" method="post">
				<?= csrf() ?>
				<input class="entradas__submit" type="submit" value="Inscripcion básica">
			</form>
		</div>

	</div>

</main>

<script>
	// Boton de paypal pago presencial 
	paypal.Buttons({
		createOrder: function(data, actions) {
			return actions.order.create({
				purchase_units: [{
					description: "1",
					amount: {
						currency_code: "EUR",
						value: "70.00"
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
					.then(json => {
						if (json.resultado === true) {
							actions.redirect('http://localhost:3000/finalizar/conferencias');
							//actions.redirect('https://joelroman.site/finalizar/conferencias');
							return;
						}
						if (json.resultado === false) {
							window.location.href = 'http://localhost:3000';
							//window.location.href = 'https://joelroman.site';
							return;
						}
						if (json.resultado === 'error') {
							alert('Ha habido un error. Por favor, inténtalo de nuevo.');
							return;
						}
						alert('Respuesta inesperada. Vuelve a intentarlo.');
					})
					.catch(error => {
						console.error('Error en fetch o al parsear JSON:', error);
						alert('Ha ocurrido un error. Por favor, inténtalo más tarde.');
					});
			});
		},
		onError: function(err) {
			console.error(err);
			alert('Error al procesar el pago.');
		}
	}).render('#paypal-button-container-presencial');

	//boton de virtual
	paypal.Buttons({
		createOrder: function(data, actions) {
			return actions.order.create({
				purchase_units: [{
					description: "2",
					amount: {
						currency_code: "EUR",
						value: "200.00"
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
					.then(json => {
						if (json.resultado === true) {
							actions.redirect('http://localhost:3000/finalizar');
							//actions.redirect('https://joelroman.site/finalizar');

							return;
						}

						if (json.resultado === false) {
							// Recomendable por paypal para interrumpir si hay eror
							window.location.href = 'http://localhost:3000'; 
							//window.location.href = 'https://joelroman.site';
							return;
						}
						if (json.resultado === 'error') {
							alert('Ha habido un error. Por favor, inténtalo de nuevo.');
							return;
						}
						alert('Respuesta inesperada. Vuelve a intentarlo.');
					})
					.catch(error => {
						console.error('Error en fetch o al parsear JSON:', error);
						alert('Ha ocurrido un error. Por favor, inténtalo más tarde.');
					});

			});
		},
		onError: function(err) {
			console.error(err);
			alert('Error al procesar el pago.');
		}
	}).render('#paypal-button-container-virtual');
</script>