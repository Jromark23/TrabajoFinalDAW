<?php

namespace Controllers;

use Classes\Paginacion;
use Model\Ponente;
use MVC\Router;
use Intervention\Image\ImageManagerStatic as Image;

class RegistroController
{

	public static function crear(Router $router)
	{

		$router->renderizar('registro/crear', [
			'titulo' => 'Completar registro'
		]);
	}

	public static function basico(Router $router)
	{

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			if (!is_user()) {
				header('Location: /login');
			}
		}

		$token = substr(md5(uniqid(rand(), true)), 0, 5);
	}

	public static function virtual(Router $router)
	{

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			if (!is_user()) {
				header('Location: /login');
			}
		}

		$token = substr(md5(uniqid(rand(), true)), 0, 5);
	}

	public static function presencial(Router $router)
	{

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			if (!is_user()) {
				header('Location: /login');
			}
		}

		$token = substr(md5(uniqid(rand(), true)), 0, 5);
	}
}
