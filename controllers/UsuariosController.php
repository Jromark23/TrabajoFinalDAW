<?php

namespace Controllers;

use MVC\Router;
use Model\Registro;
use Model\Paquete;
use Model\Usuario;
use Classes\Paginacion;

class UsuariosController {

	public static function index(Router $router) {
		if (!is_admin()) {
			header('Location: /login');
			exit;
		}

		// obtenemos numero de pagina y validamos
		$pagina_actual = $_GET['page'];
		$pagina_actual = filter_var($pagina_actual, FILTER_VALIDATE_INT);

		// si no es valido, dirigimos a la 1 
		if (!$pagina_actual || $pagina_actual < 1) {
			header('Location: /admin/usuarios?page=1');
			exit;
		}

		$registros_pagina = 6;
		$total_registros = Registro::count();
		$paginacion = new Paginacion($pagina_actual, $registros_pagina, $total_registros);
		
		if ($paginacion->total_paginas() < $pagina_actual) {
			header('Location: /admin/usuarios?page=1');
			exit;
		}

		$registros = Registro::paginar($registros_pagina, $paginacion->offset());
		
		foreach($registros as $registro) {
			$registro->usuario = Usuario::find($registro->usuario_id);
			$registro->paquete = Paquete::find($registro->paquete_id);
		}

		$router-> renderizar('admin/usuarios/index', [
			'titulo' => 'Usuarios',
			'registros' => $registros,
			'paginacion' => $paginacion->paginacion()
		]);
	}

}



