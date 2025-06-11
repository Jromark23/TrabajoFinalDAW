// Se ejecuta en cuanto se interprete el archivo -> (function() { })()
// Evita que se ejecute o falle en otra pagina
(function () {
	const tagsInput = document.querySelector('#tags_input');

	if (tagsInput) {

		const tagsDiv = document.querySelector('#tags');
		const tagsHidden = document.querySelector('[name="tags"]');

		let tags = [];

		tagsInput.addEventListener('keydown', guardarTag);

		// Recuperar tags cuando editamos ponente
		if (tagsHidden.value.trim() !== '') {
			tags = tagsHidden.value.split(',');
			mostrarTags();
		}


		// Funciones

		// Guarda un tag cuando se pulsa espacio y lo añade al array de tags
		function guardarTag(event) {

			if (event.key === ' ') {
				event.preventDefault();

				if (event.target.value.trim() == '' || event.target.value < 1)
					return;


				tags = [...tags, event.target.value.trim()];
				tagsInput.value = '';

				mostrarTags();
			}

		}

		// Muestra los tags actuales en el DOM y actualiza el campo oculto
		function mostrarTags() {
			tagsDiv.textContent = "";

			tags.forEach(tag => {
				const etiqueta = document.createElement('li');
				etiqueta.classList.add('formulario__tag');
				etiqueta.textContent = tag;

				etiqueta.ondblclick = eliminarTag;

				tagsDiv.appendChild(etiqueta);
			})

			actualizarHidden();
		}

		// Actualiza el input hidden con la lista de tags actual
		function actualizarHidden() {
			tagsHidden.value = tags.toString();
		}

		// Elimina un tag del array y del DOM al hacer doble click
		function eliminarTag(e) {
			e.target.remove();			
			// -1 si no lo encuentra 
			const index = tags.indexOf(e.target.textContent);

			if (index > -1) {
				// desde index, n elementos
				tags.splice(index, 1); 
			}

			actualizarHidden();
		}

	}
})();