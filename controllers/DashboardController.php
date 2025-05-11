<?php

namespace Controllers;

use MVC\Router;

class DashboardController {

	public static function index(Router $router) {

		if (!is_admin()) {
			header('Location: /login');
			exit;
		}
		
		$router-> renderizar('admin/dashboard/index', [
			'titulo' => 'Panel de administación'
		]);
	}

}