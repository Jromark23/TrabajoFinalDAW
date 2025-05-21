import Swal from 'sweetalert2';

// Se ejecuta en cuanto se interprete el archivo -> (function() { })()
// Evita que se ejecute o falle en otra pagina
(function () {
	let eventos = [];
	const maxEventos = 5; // maximo de eventos que dejaremos seleccionar
	const carrito = document.getElementById('registro-carro');

	let eventosBoton = document.querySelectorAll('.evento__boton');

	eventosBoton.forEach(boton => boton.addEventListener('click', seleccionarEvento))


	function seleccionarEvento(e) {

		if (eventos.length < maxEventos) {
			// Recogemos el ID del evento desde dataset y el nombre yendo hacia el padre del target
			eventos = [...eventos, {
				id: e.target.dataset.id,
				titulo: e.target.parentElement.querySelector('.evento__nombre').textContent
			}]

			// Deshabilitar el evento al seleccionarlo y colocarlo en el carrito
			e.target.disabled = true;

			console.log(eventos);

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


	function mostrarEventos() {

		carrito.innerHTML = '';

		if (eventos.length > 0) {
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
		}
	}

	function eliminarEvento(id) {
		// Recogemos todos los que tienen el distinto ID
		eventos = eventos.filter(evento => evento.id !== id);

		// Habilitamos el boton de nuevo y actualizamos los eventos del carrito
		const btnAgregar = document.querySelector(`[data-id="${id}"]`);
		btnAgregar.disabled = false;
		mostrarEventos();
	}

})();


