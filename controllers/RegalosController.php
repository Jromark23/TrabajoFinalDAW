<?php

namespace Controllers;

use MVC\Router;

/**
 * Controlador para la gestión de regalos en admin.
 */
class RegalosController {

    /**
     * Muestra la vista de regalos para cargar la gráfica.
     *
     * @param Router $router
     * @return void
     */
	public static function index(Router $router) {
		if (!is_admin()) {
			header('Location: /login');
			exit;
		}
		$router-> renderizar('admin/regalos/index', [
			'titulo' => 'Regalos'
		]);
	}

}