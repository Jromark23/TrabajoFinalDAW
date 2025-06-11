// core version + navigation, pagination modules:
import Swiper from 'swiper';
import { Navigation, Pagination } from 'swiper/modules';
// import Swiper and modules styles
import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';

// Espera a que el DOM esté listo para inicializar el slider
document.addEventListener('DOMContentLoaded', function () {
	if (document.querySelector('.slider')) {

		// Configuración del carrusel 
		const opciones = {
			loop: true,								// Continua al llegar al final
			slidesPerView: 1,
			spaceBetween: 20,
			pagination: {
				el: '.swiper-pagination',			// Bolitas para paginar
				clickable: true,
			},
			navigation: {
				nextEl: '.swiper-button-next',		// Botones laterales de navegacion
				prevEl: '.swiper-button-prev',		
			},
			effect: 'fade',							// Efecto de transicion
			breakpoints: {
				768: {
					slidesPerView: 2
				},
				1024: {
					slidesPerView: 3
				},
				1200: {
					slidesPerView: 4
				}
			}
		};

		// Inicializa Swiper con los módulos de navegación y paginación
		Swiper.use([Navigation, Pagination]);
		new Swiper('.slider', opciones);
	}

});