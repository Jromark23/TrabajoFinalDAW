// Se ejecuta en cuanto se interprete el archivo -> (function() { })()
// Evita que se ejecute o falle en otra pagina y encapsula variables y funciones    (IIFE)
// JS para los ponentes de editar eventos
(function () {
	const ponentesId = document.querySelector('#ponentes');

	if (!ponentesId)
		return;

	let ponentes = [];
	let ponentesFiltrados = [];
	const listaPonentes = document.querySelector('#listaPonentes');
	const ponenteHidden = document.querySelector('[name="ponente_id"]');

	// Obtiene todos los ponentes de la API y los formatea
	obtenerPonentes();
	ponentesId.addEventListener('input', buscarPonentes);

	// Si hay un ponente seleccionado al cargar, lo muestra
	if (ponenteHidden.value) {
		async function forzarEjecucion() {
			const ponente = await obtenerPonente(ponenteHidden.value);
			
			// Insertarlo en el HTML
			const ponenteHTML = document.createElement('LI');
			ponenteHTML.classList.add('listaPonentes__ponente', 'listaPonentes__ponente--selected');
			ponenteHTML.textContent = `${ponente.nombre} ${ponente.apellido}`;
			document.querySelector('#ponentes').value = `${ponente.nombre} ${ponente.apellido}`;
			listaPonentes.appendChild(ponenteHTML);
		}

		forzarEjecucion();
	}

	// Solicita la lista de ponentes a la API
	async function obtenerPonentes() {
		const url = `/api/ponentes`;

		const respuesta = await fetch(url);
		const resultado = await respuesta.json();
		formatearPonentes(resultado);
	}

	// Solicita un ponente concreto por ID a la API
	async function obtenerPonente(id) {
		const url = `/api/ponente?id=${id}`;

		const respuesta = await fetch(url);
		const resultado = await respuesta.json();
		return resultado;
	}

	// Formatea los ponentes para facilitar la búsqueda
	// Convertimos para solo coger la info que queremos 
	function formatearPonentes(arrayPonentes = []) {
		ponentes = arrayPonentes.map(ponente => {
			return {
				nombre: `${ponente.nombre.trim()} ${ponente.apellido.trim()}`,
				id: ponente.id
			}
		})
	}

	// Filtra los ponentes según el texto introducido
	function buscarPonentes(e) {
		ponenteHidden.value = '';
		// Eliminamos las tildes para la busqueda
		const busqueda = e.target.value.normalize('NFD').replace(/[\u0300-\u036f]/g, '');

		if (busqueda.length > 0) {
			// flag i acepta mayuscula y minuscula
			const regex = new RegExp(busqueda, "i");
			ponentesFiltrados = ponentes.filter(ponente => {
				const nombreNormalizado = ponente.nombre.normalize('NFD').replace(/[\u0300-\u036f]/g, '');
				if (nombreNormalizado.search(regex) != -1) {
					return ponente;
				}
			})
		} else {
			// Evita que se quede al borrar los nombres 
			ponentesFiltrados = [];
		}
		mostrarPonentes();
	}

	// Muestra los ponentes filtrados en la lista
	function mostrarPonentes() {
		//Limpiamos para evitar que se autoacumule
		listaPonentes.innerHTML = '';

		if (ponentesFiltrados.length > 0) {

			ponentesFiltrados.forEach(ponente => {
				const ponenteHTML = document.createElement('LI');
				ponenteHTML.classList.add('listaPonentes__ponente');
				ponenteHTML.textContent = ponente.nombre;
				ponenteHTML.dataset.ponenteId = ponente.id;
				ponenteHTML.onclick = seleccionarPonente;

				listaPonentes.appendChild(ponenteHTML);
			})
		} else {
			const vacio = document.createElement('P');
			vacio.classList.add('listaPonentes__vacio');
			vacio.textContent = "No se han encontrado resultados";

			listaPonentes.appendChild(vacio);
		}
	}

	// Selecciona un ponente de la lista y lo marca como seleccionado
	function seleccionarPonente(e) {
		ponenteHidden.value = '';

		//Deshabilita ponente anterior si la hay 
		const ponentePrevio = document.querySelector('.listaPonentes__ponente--selected');
		if (ponentePrevio) {
			ponentePrevio.classList.remove('listaPonentes__ponente--selected')
		}

		const ponente = e.target;
		ponente.classList.add('listaPonentes__ponente--selected');

		ponenteHidden.value = ponente.dataset.ponenteId;
	}

})();


