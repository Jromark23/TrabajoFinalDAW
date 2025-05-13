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
		$eventos = Evento::whereOrden('hora_id','ASC');
		
		$eventos_formateados = [];

		foreach ($eventos as $evento) {

			$evento->categoria = Categoria::find($evento->categoria_id);
			$evento->dia = Dia::find($evento->dia_id);
			$evento->hora = Hora::find($evento->hora_id);
			$evento->ponente = Ponente::find($evento->ponente_id);

			if ($evento->dia_id === '1' && $evento->categoria_id === '1') {
				$eventos_formateados['conferencia_v'][] = $evento;
			}
			if ($evento->dia_id === '2' && $evento->categoria_id === '1') {
				$eventos_formateados['conferencia_s'][] = $evento;
			}
			if ($evento->dia_id === '1' && $evento->categoria_id === '2') {
				$eventos_formateados['taller_v'][] = $evento;
			}
			if ($evento->dia_id === '2' && $evento->categoria_id === '2') {
				$eventos_formateados['taller_s'][] = $evento;
			}
		}

		//debuguear($eventos_formateados);

		$router->renderizar(('paginas/eventos'), [
			'titulo' => 'Conferencias & talleres',
			'eventos' => $eventos_formateados
		]);
	}

	


}
