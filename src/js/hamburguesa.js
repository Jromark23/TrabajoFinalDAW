// Se ejecuta en cuanto se interprete el archivo -> (function() { })()
// Evita que se ejecute o falle en otra pagina y encapsula variables y funciones 
document.addEventListener('DOMContentLoaded', function() {
	const btn = document.getElementById('btnHamburguesa');
	const barra = document.getElementById('barraMenu');
	btn.addEventListener('click', function(e) {
		e.stopPropagation();
		barra.classList.toggle('barra__visible');
	});
	document.addEventListener('click', function(e) {
		if (!barra.contains(e.target) && !btn.contains(e.target)) {
			barra.classList.remove('barra--visible');
		}
	});
});

