<?php

namespace Controllers;

use MVC\Router;

class RegalosController {

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