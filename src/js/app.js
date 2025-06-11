import './horas.js';
import './ponentes.js';
import './tags.js';
import './slider.js';
import './mapa.js';
import './registro.js';
import './regalos.js';
import './cookies.js';
import './hamburguesa.js';
import './ponentes_busqueda.js';


// Evita el envío de los formulario con Enter
document.addEventListener('keydown', function (event) {
	if (event.key === 'Enter') {
		// Verifica si está en un input tipo submit
		const element = document.activeElement;
		if (element.tagName === 'INPUT' && element.type === 'submit') {
			return; // Permite el uso normal
		}

		// En cualquier otro caso, evita el comportamiento por defecto
		event.preventDefault();
	}
});

document.addEventListener("DOMContentLoaded", function () {
	// Enlaces que tengan data-scroll
	const enlaces = document.querySelectorAll('a[data-scroll]');

	// Añade scroll suave a los enlaces con data-scroll
	enlaces.forEach(enlace => {
		enlace.addEventListener('click', function (e) {
			e.preventDefault();

			const destino = this.getAttribute('href'); // Todas las redirecciones
			const idObjetivo = this.dataset.scroll;   // 'localizador'

			// Si ya esta en la pagina
			if (window.location.pathname === destino) {
				// Scroll directo 
				const objetivo = document.getElementById(idObjetivo);
				if (objetivo) {
					objetivo.scrollIntoView({ behavior: 'smooth' });
					// Borra el hash de la URL por si acaso
					history.replaceState(null, '', destino);
				}
			} else {
				// Guarda en sessionStorage a dónde quieres hacer scroll
				sessionStorage.setItem('scrollTo', idObjetivo);
				window.location.href = destino;
			}
		});
	});

	// Si vienes de otra página y se ha guardado un destino de scroll
	const destinoGuardado = sessionStorage.getItem('scrollTo');
	if (destinoGuardado) {
		const objetivo = document.getElementById(destinoGuardado);
		if (objetivo) {
			objetivo.scrollIntoView({ behavior: 'smooth' });
		}
		// Eliminar para que no se repita el scroll en el futuro
		sessionStorage.removeItem('scrollTo');
	}
});

