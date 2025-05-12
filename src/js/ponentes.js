// Se ejecuta en cuanto se interprete el archivo -> (function() { })()
// Evita que se ejecute o falle en otra pagina y encapsula variables y funciones    (IIFE)
(function () {
	const ponentesId = document.querySelector('#ponentes');

	if (ponentesId) {
		let ponentes = [];
		let ponentesFiltrados = [];
		const listaPonentes = document.querySelector('#listaPonentes');
		const ponenteHidden = document.querySelector('[name="ponente_id"]');

		obtenerPonentes();
		ponentesId.addEventListener('input', buscarPonentes);


		async function obtenerPonentes() {
			const url = `/api/ponentes`;

			const respuesta = await fetch(url);
			const resultado = await respuesta.json();
			formatearPonentes(resultado);
		}

		// Convertimos para solo coger la info que queremos 
		function formatearPonentes(arrayPonentes = []) {
			ponentes = arrayPonentes.map(ponente => {
				return {
					nombre: `${ponente.nombre.trim()} ${ponente.apellido.trim()}`,
					id: ponente.id
				}
			})
		}

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
	}


})();


