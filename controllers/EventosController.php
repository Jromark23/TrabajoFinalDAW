<?php

namespace Controllers;

use MVC\Router;

class EventosController {

	public static function index(Router $router) {
		if (!is_admin()) {
			header('Location: /login');
			exit;
		}
		$router-> renderizar('admin/eventos/index', [
			'titulo' => 'Eventos'
		]);
	}

}