// Se ejecuta en cuanto se interprete el archivo -> (function() { })()
// Evita que se ejecute o falle en otra pagina y encapsula variables y funciones 
(function () {
	const horas = document.querySelector('#horas');

	// Si no hay horas, paramos la ejecucion
	if (!horas)
		return;

	// Seleccionamos los días para buscar cual está activo
	const dias = document.querySelectorAll('[name="dia"]');
	const hiddenDia = document.querySelector('[name="dia_id"]');
	const hiddenHora = document.querySelector('[name="hora_id"]');
	const categoria = document.querySelector('[name="categoria_id"]');

	categoria.addEventListener('change', asignarBusqueda);
	dias.forEach(dia => dia.addEventListener('change', asignarBusqueda));

	/* Objeto para realizar la busqueda de los eventos. 
		recuperando valores si editamos, o dejando vacios si creamos*/
	let busqueda = {
		categoria_id: categoria.value || '',
		dia: hiddenDia.value || ''
	}

	// Al editar evento, fuerza buscar el evento para cargar las horas. 
	// al ser asincrona lo metemos en una funcion y forzamos su ejecucion
	if (!Object.values(busqueda).includes('')) {

		// Busca los eventos y resalta la hora seleccionada al editar
		async function forzarEjecucion() {
			await buscarEventos();

			const id = hiddenHora.value;
			//Resaltar la hora a la que esta asociado el evento.
			// Buscamos por el dataset y cambiamos disabled por selected
			const horaSeleccionada = document.querySelector(`[data-hora-id="${id}"]`);
			horaSeleccionada.classList.remove('horas__hora--disabled');
			horaSeleccionada.classList.add('horas__hora--selected');

			horaSeleccionada.onclick = seleccionarHora;
		}

		forzarEjecucion();
	}

	// Actualiza el objeto de búsqueda y reinicia los campos ocultos al cambiar día o categoría
	function asignarBusqueda(e) {
		busqueda[e.target.name] = e.target.value;

		//Reiniciar campos cada vez que cambiamos
		hiddenDia.value = '';
		hiddenHora.value = '';

		//Deshabilita la hora anterior si la hay 
		const horaPrevia = document.querySelector('.horas__hora--selected');
		if (horaPrevia) {
			horaPrevia.classList.remove('horas__hora--selected')
		}

		// Nos permite saber si solo está uno completado. 
		if (Object.values(busqueda).includes('')) {
			return;
		}
		buscarEventos();
	}


	// Busca los eventos disponibles según el día y la categoría seleccionados
	async function buscarEventos() {

		const { dia, categoria_id } = busqueda;
		const url = `/api/horarios-eventos?dia_id=${dia}&categoria_id=${categoria_id}`;

		//console.log(url);

		const resultado = await fetch(url);
		const eventos = await resultado.json();

		obtenerHorarios(eventos);
	}

	// Habilita o deshabilita las horas según los eventos ocupados
	function obtenerHorarios(eventos) {
		// Seleccionamos todas las horas de la lista y las reiniciamos
		const listaHoras = document.querySelectorAll('#horas li');
		listaHoras.forEach(li => li.classList.add('horas__hora--disabled'));

		// Comprobamos los eventos, y quitamos el deshabilitado a las horas que corresponda
		const horasUsadas = eventos.map(evento => evento.hora_id);

		// Convertimos a un array (Tenemos NodeList) para poder usar el arrayMethod "filter"
		const listaHorasArray = Array.from(listaHoras);


		const resultado = listaHorasArray.filter(li => !horasUsadas.includes(Number(li.dataset.horaId)));

		resultado.forEach(li => li.classList.remove('horas__hora--disabled'))

		// Traemos las horas que no estan deshabilitadas
		const horas = document.querySelectorAll('#horas li:not(.horas__hora--disabled)');

		horas.forEach(hora => hora.addEventListener('click', seleccionarHora));
	}

	// Selecciona una hora disponible y actualiza los campos ocultos
	function seleccionarHora(e) {
		//Deshabilita la hora anterior si la hay 
		const horaPrevia = document.querySelector('.horas__hora--selected');
		if (horaPrevia) {
			horaPrevia.classList.remove('horas__hora--selected')
		}
		//console.log(e.target.dataset.horaId);
		hiddenHora.value = e.target.dataset.horaId;

		//Agregamos clase para mantener visualmente la seleccion, asegurando que es una hora libre
		if (!e.target.classList.contains('horas__hora--disabled')) {
			e.target.classList.add('horas__hora--selected');
		}

		// Llenamos el campo oculto con el dia que tiene check 
		hiddenDia.value = document.querySelector('[name="dia"]:checked').value;
	}
})();


