import Swal from 'sweetalert2';

// Se ejecuta en cuanto se interprete el archivo -> (function() { })()
// Evita que se ejecute o falle en otra pagina
(function () {
	let eventos = [];
	const maxEventos = 5; // maximo de eventos que dejaremos seleccionar
	const carrito = document.getElementById('registro-carro');

	if (carrito) {
		let eventosBoton = document.querySelectorAll('.evento__boton');
		eventosBoton.forEach(boton => boton.addEventListener('click', seleccionarEvento))


		const formularioRegistro = document.querySelector('#registro');
		formularioRegistro.addEventListener('submit', enviarFormulario)

		// Permite seleccionar un evento y añadirlo al carrito
		function seleccionarEvento(e) {

			if (eventos.length < maxEventos) {
				// Recogemos el ID del evento desde dataset y el nombre yendo hacia el padre del target
				eventos = [...eventos, {
					id: e.target.dataset.id,
					titulo: e.target.parentElement.querySelector('.evento__nombre').textContent
				}]

				// Deshabilitar el evento al seleccionarlo y colocarlo en el carrito
				e.target.disabled = true;

				//console.log(eventos);

				mostrarEventos();
			} else {
				Swal.fire({
					title: 'Error',
					text: "Máximo 5 eventos",
					icon: 'error',
					confirmButtonText: 'Aceptar'
				})
			}
		}


		// Muestra los eventos seleccionados en el carrito
		function mostrarEventos() {

			carrito.innerHTML = '';
			document.querySelector("#carroVacio").style.display = 'block';

			if (eventos.length > 0) {
				document.querySelector("#carroVacio").style.display = 'none';

				eventos.forEach(evento => {
					const aniadirEvento = document.createElement('DIV');
					aniadirEvento.classList.add('registro__evento');

					const titulo = document.createElement('H3');
					titulo.classList.add('registro__nombre');
					titulo.textContent = evento.titulo;

					const eliminarBtn = document.createElement('BUTTON');
					eliminarBtn.classList.add('registro__eliminar');
					eliminarBtn.innerHTML = `<i class="fa-solid fa-trash"></i>`;
					eliminarBtn.onclick = function () {
						eliminarEvento(evento.id);
					}

					aniadirEvento.appendChild(titulo);
					aniadirEvento.appendChild(eliminarBtn);
					carrito.appendChild(aniadirEvento);
				})
			} else {
				//document.querySelector("#carroVacio").style.display = 'block';
				// const errorRegistro = document.createElement("P");
				// errorRegistro.textContent = "No hay eventos, añade hasta 5";
				// errorRegistro.classList.add("registro__texto");
				// carrito.appendChild(errorRegistro);
			}
		}

		// Elimina un evento del carrito y habilita su botón
		function eliminarEvento(id) {
			// Recogemos todos los que tienen el distinto ID
			eventos = eventos.filter(evento => evento.id !== id);

			// Habilitamos el boton de nuevo y actualizamos los eventos del carrito
			const btnAgregar = document.querySelector(`[data-id="${id}"]`);
			btnAgregar.disabled = false;
			mostrarEventos();
		}

		// Envía el formulario de registro con los eventos y regalo seleccionados
		async function enviarFormulario(e) {
			e.preventDefault();

			// Obtenemos el ID del regalo y los eventos seleccionados 
			const regaloId = document.querySelector("#regalo").value;
			const eventosId = eventos.map(evento => evento.id);

			if (eventosId.length === 0 || regaloId === "") {
				Swal.fire({
					title: 'Error',
					text: "Debe seleccionar al menos un evento y un regalo.",
					icon: 'error',
					confirmButtonText: 'Aceptar'
				});
				return;
			}

			// Preparamos los datos a enviar con un objeto FormData
			const datos = new FormData();
			datos.append('eventos', eventosId);
			datos.append('regalo_id', regaloId);

			console.log("log1");
			try {
				console.log("log2");
				const url = '/finalizar/conferencias';
				const respuesta = await fetch(url, {
					method: 'POST',
					body: datos
				});

				console.log("log3");
				if (!respuesta.ok) throw new Error("Error en la solicitud");
				console.log("log4");

				const resultado = await respuesta.json();
				//console.log(resultado);

				console.log("log5");
				if (resultado.resultado) {

					// Mensjae de OK
					Swal.fire({
						title: '¡Completado!',
						text: "Formulario enviado correctamente.",
						icon: 'success',
						confirmButtonText: 'Aceptar'
					}).then(() => location.href = `/entrada?id=${resultado.token}`);
				} else {
					Swal.fire({
						title: 'Error',
						text: "Hubo un problema con la compra, revisa si aún quedan entradas.",
						icon: 'error',
						confirmButtonText: 'Aceptar'
					}).then(() => location.reload());
				}
			} catch (error) {

				console.error(error);

				Swal.fire({
					title: 'Error',
					text: "Hubo un problema al enviar el formulario.",
					icon: 'error',
					confirmButtonText: 'Aceptar'
				});
			}
		}



	}


})();


