import './horas.js';
import './ponentes.js';
import './tags.js';
import './slider.js';


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
