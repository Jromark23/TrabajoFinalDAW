<?php

namespace Controllers;

use Model\Categoria;
use Model\Ponente;
use Model\Dia;
use Model\Evento;
use Model\Hora;
use MVC\Router;
use Classes\Paginacion;

/**
 * Controlador para la gestión de eventos en el panel de administración.
 */
class EventosController
{
    /**
     * Muestra la lista de eventos de manera paginada.
     *
     * @param Router $router
     * @return void
     */
	public static function index(Router $router)
	{
		if (!is_admin()) {
			header('Location: /login');
			exit;
		}

		// Obtenemos número de página y validamos
		$pagina_actual = $_GET['page'];
		$pagina_actual = filter_var($pagina_actual, FILTER_VALIDATE_INT);

		// si no es válido, dirigimos a la 1 
		if (!$pagina_actual || $pagina_actual < 1) {
			header('Location: /admin/eventos?page=1');
		}

		$registros_pagina = 6;
		$total_registros = Evento::count();
		$paginacion = new Paginacion($pagina_actual, $registros_pagina, $total_registros);

		if ($paginacion->total_paginas() < $pagina_actual) {
			header('Location: /admin/eventos?page=1');
		}

		$eventos = Evento::paginar($registros_pagina, $paginacion->offset());

		foreach ($eventos as $evento) {
			$evento->categoria = Categoria::find($evento->categoria_id);
			$evento->ponente = Ponente::find($evento->ponente_id);
			$evento->dia = Dia::find($evento->dia_id);
			$evento->hora = Hora::find($evento->hora_id);
		}


		$router->renderizar('admin/eventos/index', [
			'titulo' => 'Eventos',
			'eventos' => $eventos,
			'paginacion' => $paginacion->paginacion()
		]);
	}

    /**
     * Muestra el formulario para crear un nuevo evento y también gestiona su registro.
     *
     * @param Router $router
     * @return void
     */
	public static function crear(Router $router)
	{
		if (!is_admin()) {
			header('Location /login');
			exit;
		}

		$alertas = [];
		$categorias = Categoria::all();
		$dias = Dia::all('ASC');
		$horas = Hora::all('ASC');

		$evento = new Evento;

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			validar_csrf();

			$evento->sincronizar($_POST);

			$alertas = $evento->validar();

			if (empty($alertas)) {
				$resultado = $evento->guardar();

				if ($resultado) {
					header('Location: /admin/eventos');
					exit;
				}
			}
		}

		$router->renderizar('admin/eventos/crear', [
			'titulo' => 'Registrar evento',
			'alertas' => $alertas,
			'categorias' => $categorias,
			'dias' => $dias,
			'horas' => $horas,
			'evento' => $evento
		]);
	}

    /**
     * Muestra el formulario para editar un evento y gestiona su actualización.
     *
     * @param Router $router
     * @return void
     */
	public static function editar(Router $router)
	{
		if (!is_admin()) {
			header('Location /login');
			exit;
		}
		$alertas = [];

		// Validar ID
		$id = $_GET['id'];
		$id = filter_var($id, FILTER_VALIDATE_INT);
		if (!$id) {
			header('Location: /admin/eventos');
			exit;
		}

		$categorias = Categoria::all();
		$dias = Dia::all('ASC');
		$horas = Hora::all('ASC');

		//Obtenerlo y mandarlo a editar
		$evento = Evento::find($id);
		if (!$evento) {
			header('Location: /admin/eventos');
			exit;
		}


		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			validar_csrf();

			if (!is_admin()) {
				header('Location: /login');
				exit;
			}
			$evento->sincronizar($_POST);
			$alertas = $evento->validar();

			if (empty($alertas)) {

				$resultado = $evento->guardar();
				if ($resultado) {
					header('Location: /admin/eventos');
					exit;
				}
			}
		}

		$router->renderizar('admin/eventos/editar', [
			'titulo' => 'Actualizar evento',
			'alertas' => $alertas,
			'categorias' => $categorias,
			'dias' => $dias,
			'horas' => $horas,
			'evento' => $evento
		]);
	}

    /**
     * Elimina el evento seleccionado.
     *
     * @param Router $router
     * @return void
     */
	public static function eliminar(Router $router)
	{
		if (!is_admin()) {
			header('Location /login');
			exit;
		}
		$alertas = [];

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			validar_csrf();
			$id = $_POST['id'];

			$evento = Evento::find($id);
			if (!isset($evento)) {
				header('Location: /admin/eventos');
				exit;
			}
			$resultado = $evento->eliminar();

			if ($resultado) {
				header('Location: /admin/eventos');
				exit;
			}
		}
	}
}
