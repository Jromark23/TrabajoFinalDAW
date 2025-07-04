// Se ejecuta en cuanto se interprete el archivo -> (function() { })()
// Evita que se ejecute o falle en otra pagina
if (document.querySelector('#map')) {
	// Inicializa el mapa centrado en la zona que queramos
	var map = L.map('map').setView([40.34165110717421, -3.832417846318466], 15);

	// Añade la capa de OpenStreetMap al mapa
	L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
		attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
	}).addTo(map);

	// Añade un marcador con un popup
	L.marker([40.34165110717421, -3.832417846318466]).addTo(map)
		.bindPopup(`
			<p class="mapa__p">Ven a conocernos</p>  `)
		.openPopup();
}
