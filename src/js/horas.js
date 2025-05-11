// Se ejecuta en cuanto se interprete el archivo -> (function() { })()
// Evita que se ejecute o falle en otra pagina y encapsula variables y funciones 
(function () {
	const horas = document.querySelector('#horas');

	if (horas) {
		// Seleccionamos los días para buscar cual está activo
		const dias = document.querySelectorAll('[name="dia"]');
		const hidden = document.querySelector('[name="dia_id"]');
		const categoria = document.querySelector('[name="categoria_id"]');

		// Asignamos para poder tener controlado sincronizadas horas y dias y mostrar en directo
		let busqueda = {
			categoria_id: '',
			dia: ''
		}
		
		categoria.addEventListener('change', asignarBusqueda);
		dias.forEach(dia => dia.addEventListener('change', asignarBusqueda));

		function asignarBusqueda(e) {
			busqueda[e.target.name] = e.target.value;
		}
	}
})();


