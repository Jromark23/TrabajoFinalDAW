document.addEventListener('DOMContentLoaded', function () {
	const inputBusqueda = document.querySelector('#ponentes__buscar');
	const tablaPonentes = document.querySelector('.table__tbody');
	const mensajeNoResultados = document.querySelector('.text-center');
	const divTabla = document.querySelector('.tabla-scroll');
	let todosPonentes = []; // Almacenará todos los ponentes

	if (!inputBusqueda) return;

	// Cargar todos los ponentes al iniciar
	cargarPonentes();

	inputBusqueda.addEventListener('input', function (e) {
		const busqueda = e.target.value.trim().toLowerCase();
		filtrarPonentes(busqueda);
	});

	async function cargarPonentes() {
		try {
			const respuesta = await fetch('/api/ponentes');
			todosPonentes = await respuesta.json();
			mostrarPonentes(todosPonentes);
		} catch (error) {
			console.error('Error al cargar ponentes:', error);
		}
	}

	function filtrarPonentes(termino) {
		if (termino.length > 0) {
			const ponentesFiltrados = todosPonentes.filter(ponente => {
				const nombreCompleto = `${ponente.nombre} ${ponente.apellido}`.toLowerCase();
				const ciudadPais = `${ponente.ciudad}, ${ponente.pais}`.toLowerCase();

				return nombreCompleto.includes(termino) ||
					ciudadPais.includes(termino);
			});
			mostrarPonentes(ponentesFiltrados);
		} else {
			mostrarPonentes(todosPonentes);
		}
	}

	function mostrarPonentes(ponentes) {
		if (ponentes.length > 0) {
			if (divTabla) divTabla.style.display = 'block';
			if (mensajeNoResultados) mensajeNoResultados.style.display = 'none';

			let html = '';

			ponentes.forEach(ponente => {
				html += `
                    <tr class="table__tr">
                        <td class="table__td">
                            ${ponente.nombre} ${ponente.apellido}
                        </td>
                        <td class="table__td">
                            ${ponente.ciudad}, ${ponente.pais}
                        </td>
                        <td class="table__td--acciones">
                            <a class="table__accion table__accion--editar" href="/admin/ponentes/editar?id=${ponente.id}">
                                <i class="fa-solid fa-pen-to-square"></i>
                                Editar
                            </a>
                            <form action="/admin/ponentes/eliminar" method="POST" class="table__formulario">
                                <input type="hidden" name="csrf_token" value="${window.csrf_token}">
                                <input type="hidden" name="id" value="${ponente.id}">
                                <button class="table__accion table__accion--eliminar" type="submit">
                                    <i class="fa-solid fa-trash"></i>
                                    Eliminar
                                </button>
                            </form>
                        </td>
                    </tr>
                `;
			});

			tablaPonentes.innerHTML = html;
		} else {
			if (divTabla) divTabla.style.display = 'none';
			if (mensajeNoResultados) {
				mensajeNoResultados.style.display = 'block';
				mensajeNoResultados.textContent = 'No se encontraron ponentes';
			}
		}
	}
});