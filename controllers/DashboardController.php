<?php

namespace Controllers;

use Model\Usuario;
use Model\Paquete;
use Model\Registro;
use Model\Evento;
use MVC\Router;

/**
 * Controlador para el dashboard de admin.
 */
class DashboardController {

    /**
     * Muestra el panel principal.
     *
     * @param Router $router
     * @return void
     */
	public static function index(Router $router) {

		if (!is_admin()) {
			header('Location: /login');
			exit;
		}
		
		// Bloque para ver los ultimos registrados 
		$registros = Registro::get(5);

		foreach($registros as $registro) {
			$registro->usuario = Usuario::find($registro->usuario_id);
			$registro->paquete = Paquete::find($registro->paquete_id);
		}

		// Bloque para calcular el dinero recaudado 
		$premium = Registro::count('paquete_id', 2);
		$presenciales = Registro::count('paquete_id', 1);

		$total = ($premium * 200) + ($presenciales * 70);

		// Datos para recuperar los eventos mas y menos solicitados. 
		$disponibles = Evento::whereOrdenLimit('disponibles', 'ASC', 5);
		$ocupados = Evento::whereOrdenLimit('disponibles', 'DESC', 5);



		$router-> renderizar('admin/dashboard/index', [
			'titulo' => 'Panel de administación',
			'registros' => $registros,
			'total' => $total,
			'disponibles' => $disponibles,
			'ocupados' => $ocupados
		]);
	}

}