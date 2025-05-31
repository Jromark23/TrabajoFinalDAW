<?php

namespace Controllers;

use Model\Categoria;
use Model\Dia;
use Model\Hora;
use Model\Ponente;
use MVC\Router;
use Model\Evento;


class PaginasController
{
	// Landing de la web 
	public static function index(Router $router)
	{
		$eventos = Evento::whereOrden('hora_id', 'ASC');

		// Inicializa todas las claves necesarias como arrays vacíos
		$eventos_formateados = [
			'conferencia_v' => [],
			'conferencia_s' => [],
			'taller_v' => [],
			'taller_s' => [],
		];

		foreach ($eventos as $evento) {
			$evento->categoria = Categoria::find($evento->categoria_id);
			$evento->dia = Dia::find($evento->dia_id);
			$evento->hora = Hora::find($evento->hora_id);
			$evento->ponente = Ponente::find($evento->ponente_id);

			if ($evento->dia_id == 1 && $evento->categoria_id == 1) {
				$eventos_formateados['conferencia_v'][] = $evento;
			}
			if ($evento->dia_id == 2 && $evento->categoria_id == 1) {
				$eventos_formateados['conferencia_s'][] = $evento;
			}
			if ($evento->dia_id == 1 && $evento->categoria_id == 2) {
				$eventos_formateados['taller_v'][] = $evento;
			}
			if ($evento->dia_id == 2 && $evento->categoria_id == 2) {
				$eventos_formateados['taller_s'][] = $evento;
			}
		}

		// Obtener los totales para mostrar en directo en el inicio 
		$ponentes_total = Ponente::count();
		$conferencias_total = Evento::count('categoria_id', 1);
		$talleres_total = Evento::count('categoria_id', 2);


		// Obtener todos los ponentes
		$ponentes = Ponente::all();



		$router->renderizar('paginas/index', [
			'titulo' => 'Inicio',
			'eventos' => $eventos_formateados,
			'ponentes_total' => $ponentes_total,
			'conferencias_total' => $conferencias_total,
			'talleres_total' => $talleres_total,
			'ponentes' => $ponentes
		]);
	}

	// Sobre nosotros y el evento
	public static function nosotros(Router $router)
	{
		$router->renderizar(('paginas/nosotros'), [
			'titulo' => 'Sobre el evento'
		]);
	}

	// Pagina para los tipos de entradas
	public static function entradas(Router $router)
	{
		$router->renderizar(('paginas/entradas'), [
			'titulo' => 'Comprar entradas'
		]);
	}

	// Pagina de informacion con los eventos
	public static function eventos(Router $router)
	{
		$eventos = Evento::whereOrden('hora_id', 'ASC');

		// Inicializa todas las claves necesarias como arrays vacíos
		$eventos_formateados = [
			'conferencia_v' => [],
			'conferencia_s' => [],
			// Si quieres mostrar talleres aquí, descomenta:
			// 'taller_v' => [],
			// 'taller_s' => [],
		];

		foreach ($eventos as $evento) {
			$evento->categoria = Categoria::find($evento->categoria_id);
			$evento->dia = Dia::find($evento->dia_id);
			$evento->hora = Hora::find($evento->hora_id);
			$evento->ponente = Ponente::find($evento->ponente_id);

			if ($evento->dia_id == 1 && $evento->categoria_id == 1) {
				$eventos_formateados['conferencia_v'][] = $evento;
			}
			if ($evento->dia_id == 2 && $evento->categoria_id == 1) {
				$eventos_formateados['conferencia_s'][] = $evento;
			}
			// Si quieres talleres aquí, descomenta:
			// if ($evento->dia_id == 1 && $evento->categoria_id == 2) {
			//     $eventos_formateados['taller_v'][] = $evento;
			// }
			// if ($evento->dia_id == 2 && $evento->categoria_id == 2) {
			//     $eventos_formateados['taller_s'][] = $evento;
			// }
		}

		$router->renderizar('paginas/eventos', [
			'titulo' => 'Conferencias & talleres',
			'eventos' => $eventos_formateados
		]);
	}

	public static function talleres(Router $router)
	{
		$eventos = Evento::whereOrden('hora_id', 'ASC');

		$eventos_formateados = [
			'taller_v' => [],
			'taller_s' => [],
		];

		foreach ($eventos as $evento) {
			$evento->categoria = Categoria::find($evento->categoria_id);
			$evento->dia = Dia::find($evento->dia_id);
			$evento->hora = Hora::find($evento->hora_id);
			$evento->ponente = Ponente::find($evento->ponente_id);

			if ($evento->dia_id == 1 && $evento->categoria_id == 2) {
				$eventos_formateados['taller_v'][] = $evento;
			}
			if ($evento->dia_id == 2 && $evento->categoria_id == 2) {
				$eventos_formateados['taller_s'][] = $evento;
			}
		}

		$router->renderizar('paginas/talleres', [
			'titulo' => 'Talleres',
			'eventos' => $eventos_formateados
		]);
	}

	public static function error(Router $router)
	{
		$router->renderizar(('paginas/error'), [
			'titulo' => 'Página no encontrada'
		]);
	}
}
