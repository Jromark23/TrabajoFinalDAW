<?php

namespace Controllers;

use MVC\Router;

class DashboardController {

	public static function index(Router $router) {

		if (!is_admin()) {
			header('Location: /login');
			exit;
		}
		
		// Ver los ultimos registrados 
		




		$router-> renderizar('admin/dashboard/index', [
			'titulo' => 'Panel de administación'
		]);
	}

}