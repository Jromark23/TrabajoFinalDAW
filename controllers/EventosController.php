<?php

namespace Controllers;

use Model\Categoria;
use Model\Dia;
use Model\Hora;
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

		public static function crear(Router $router)
	{
		if (!is_admin()) {
			header('Location /login');
		}

		$alertas = [];
		$categorias = Categoria::all();
		$dias = Dia::all('ASC');
		$horas = Hora::all('ASC');
		
		//debuguear($horas);

		$router->renderizar('admin/eventos/crear', [
			'titulo' => 'Registrar evento',
			'alertas' => $alertas,
			'categorias' => $categorias,
			'dias' => $dias,
			'horas' => $horas
		]);
	}


}