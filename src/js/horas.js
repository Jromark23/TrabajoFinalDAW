// Se ejecuta en cuanto se interprete el archivo -> (function() { })()
// Evita que se ejecute o falle en otra pagina y encapsula variables y funciones 
(function () {
	const horas = document.querySelector('#horas');

	if (horas) {
		// Seleccionamos los días para buscar cual está activo
		const dias = document.querySelectorAll('[name="dia"]');
		const hiddenDia = document.querySelector('[name="dia_id"]');
		const hiddenHora = document.querySelector('[name="hora_id"]');
		const categoria = document.querySelector('[name="categoria_id"]');

		// Objeto para realizar la busqueda de los eventos
		let busqueda = {
			categoria_id: '',
			dia: ''
		}

		categoria.addEventListener('change', asignarBusqueda);
		dias.forEach(dia => dia.addEventListener('change', asignarBusqueda));


		function asignarBusqueda(e) {
			busqueda[e.target.name] = e.target.value;

			// Nos permite saber si solo está uno completado. 
			if (Object.values(busqueda).includes('')) {
				return;
			}
			buscarEventos();
		}


		async function buscarEventos() {
			
			const { dia, categoria_id} = busqueda;
			const url = `/api/horarios-eventos?dia_id=${dia}&categoria_id=${categoria_id}`;

			//console.log(url);

			const resultado = await fetch(url);
			const eventos = await resultado.json();

			obtenerHorarios();
		}

		function obtenerHorarios() {
			const horas = document.querySelectorAll('#horas li');
			
			horas.forEach(hora => hora.addEventListener('click', seleccionarHora));
		}

		function seleccionarHora(e) {
			console.log(e.target);
		}
	}
})();


