<?php

namespace Controllers;

use Classes\Email;
use Model\Usuario;
use MVC\Router;

class PaginasController
{
	public static function index(Router $router)
	{
		$router->renderizar(('paginas/index'), [
			'titulo' => 'Inicio'
		]);
	}

	public static function nosotros(Router $router)
	{
		$router->renderizar(('paginas/nosotros'), [
			'titulo' => 'Sobre el evento'
		]);
	}

	public static function entradas(Router $router)
	{
		$router->renderizar(('paginas/entradas'), [
			'titulo' => 'Comprar entradas'
		]);
	}

		public static function eventos(Router $router)
	{
		$router->renderizar(('paginas/eventos'), [
			'titulo' => 'Conferencias & talleres'
		]);
	}

	


}
