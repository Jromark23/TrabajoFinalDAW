<?php

namespace Controllers;

use Model\Paquete;
use Model\Usuario;
use Model\Registro;
use MVC\Router;
use Model\Categoria;
use Model\Dia;
use Model\Hora;
use Model\Ponente;
use Model\Regalo;
use Model\Evento;
use Model\EventosRegistros;

class RegistroController
{

	public static function crear(Router $router)
	{
		if (!is_user()) {
			header('Location: /');
			exit;
		}

		// Ver si ya esta registrado 
		$registro = Registro::where('usuario_id', $_SESSION['id']);

		//debuguear($registro);

		// Si ya esta registrado con el paquete basico, le mostramos su entrada para 
		if (isset($registro) && ($registro->paquete_id == '3' || $registro->paquete_id == '2')) {
			// urlencode evita caracteres especiales
			header('Location: /entrada?id=' . urlencode($registro->token));
			exit;
		}

		// Si esta registrado y tiene el paquete presencial lo mandamos a elegir las conferencias 
		if (isset($registro) && $registro->paquete_id == '1') {
			header('Location: /finalizar/conferencias');
			exit;
		}

		$router->renderizar('registro/crear', [
			'titulo' => 'Completar registro'
		]);
	}

	public static function basico(Router $router)
	{

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			if (!is_user()) {
				header('Location: /login');
				exit;
			}
		}

		$token = substr(md5(uniqid(rand(), true)), 0, 8);

		$datos = [
			'paquete_id' => 3,
			'pago_id' => '',
			'token' => $token,
			'usuario_id' => $_SESSION['id']
		];

		$registro = new Registro($datos);
		$resultado = $registro->guardar();

		if ($resultado) {
			// urlencode evita caracteres especiales
			header('Location: /entrada?id=' . urlencode($registro->token));
			exit;
		}
	}

	public static function virtual(Router $router)
	{

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			if (!is_user()) {
				header('Location: /login');
				exit;
			}
		}

		$token = substr(md5(uniqid(rand(), true)), 0, 8);

		$datos = [
			'paquete_id' => 2,
			'pago_id' => '',
			'token' => $token,
			'usuario_id' => $_SESSION['id']
		];

		$registro = new Registro($datos);
		$resultado = $registro->guardar();

		if ($resultado) {
			// urlencode evita caracteres especiales
			header('Location: /entrada?id=' . urlencode($registro->token));
			exit;
		}
	}

	public static function presencial(Router $router)
	{

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			if (!is_user()) {
				header('Location: /login');
				exit;
			}
		}

		$token = substr(md5(uniqid(rand(), true)), 0, 8);

		$datos = [
			'paquete_id' => 1,
			'pago_id' => '',
			'token' => $token,
			'usuario_id' => $_SESSION['id']
		];

		$registro = new Registro($datos);
		$resultado = $registro->guardar();

		if ($resultado) {
			// urlencode evita caracteres especiales
			header('Location: /entrada?id=' . urlencode($registro->token));
			exit;
		}
	}

	public static function entrada(Router $router)
	{
		$id = $_GET['id'];
		//debuguear($id);

		if (!$id || strlen($id) !== 8) {
			header('Location: /');
			exit;
		}

		$registro = Registro::where('token', $id);

		//debuguear($registro);

		if (!$registro) {
			header('Location: /');
			exit;
		}
		
		$registro->usuario = Usuario::find($registro->usuario_id);
		$registro->paquete = Paquete::find($registro->paquete_id);


		$router->renderizar('registro/entrada', [
			'titulo' => 'Asistencia al evento',
			'registro' => $registro
		]);
	}

	public static function pagar(Router $router)
	{

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			if (!is_user()) {
				header('Location: /login');
				exit;
			}
		}
		//debuguear($_POST);
		// validar que no viene vacio post 
		if (empty($_POST)) {
			echo json_encode([]);
			return;
		}

		//debuguear("aqui estoy");

		// Guardamos la respuesta de paypal
		$datos = $_POST;
		$datos['token'] = substr(md5(uniqid(rand(), true)), 0, 8);
		$datos['usuario_id'] = $_SESSION['id'];

		//debuguear($datos);
		try {
			// si viene, crear el registro en la bbdd
			$registro = new Registro($datos);
			$resultado = $registro->guardar();

			echo json_encode([
				'resultado' => $resultado
			]);
		} catch (\Throwable $th) {
			echo json_encode([
				'resultado' => 'error'
			]);
		}
	}

	public static function conferencias(Router $router)
	{
		if (!is_user()) {
			header('Location: /login');
			exit;
		}

		// Comprobar que tiene entrada presencial 
		$usuario_id = $_SESSION['id'];
		$registro = Registro::where('usuario_id', $usuario_id);

		// Si ya existe el registro y su paquete es virtual le mandamos a su entrada
		if (isset($registro) && $registro->paquete_id === '2') {
			header('Location: /entrada?id=' . urlencode($registro->token));
			exit;
		}

		// Si el paquete no es presencial, le mandamos a inicio
		if ($registro->paquete_id !== "1") {
			header('Location: /');
			exit;
		}

		// // Si ya tiene el registro, redirigir a la entrada

		// if (isset($registro->regalo_id) && $registro->paquete_id === "1") {
		// 	header('Location: /entrada?id=' . urlencode($registro->token));
		// 	exit;
		// }


		$eventos = Evento::whereOrden('hora_id', 'ASC');

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

		$regalos = Regalo::all('ASC');

		// Registro
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			if (!is_user()) {
				header('Location: /login');
				exit;
			}

			$eventos = explode(',', $_POST['eventos']);
			if (empty($eventos)) {
				echo json_encode(['resultado' => false]);
				exit;
			}

			// Obtener el usuario
			$usuario = Registro::where('usuario_id', $_SESSION['id']);
			// Si no existe el usuario, o el usuario no tiene comprado presencial, lo echamos
			if (!isset($usuario) || $usuario->paquete_id !== "1") {
				echo json_encode(['resultado' => false]);
				exit;
			}

			$eventos_aux = [];
			// Validar que quedan entradas 
			foreach ($eventos as $evento_id) {
				$evento = Evento::find($evento_id);

				if (!isset($evento) || $evento->disponibles === "0") {
					echo json_encode(['resultado' => false]);
					exit;
				}

				$eventos_aux[] = $evento;
			}

			// si quedan entradas, actualizarlas
			foreach ($eventos_aux as $evento) {
				$evento->disponibles -= 1;
				$evento->guardar();

				// guardar el registro completo en la base de datos 
				$datos = [
					'evento_id' => (int)$evento->id,
					'registro_id' => (int)$registro->id
				];

				$registro_usuario = new EventosRegistros($datos);
				$registro_usuario->guardar();
			}

			// guardart el regalo 
			$registro->sincronizar(['regalo_id' => $_POST['regalo_id']]);
			$resultado = $registro->guardar();

			if ($resultado) {
				echo json_encode([
					'resultado' => $resultado,
					'token' => $registro->token
				]);
			} else {
				echo json_encode(['resultado' => false]);
			}

			exit;
		}


		$router->renderizar('registro/conferencias', [
			'titulo' => 'Elija las 5 conferencias a las que quiere asistir',
			'eventos' => $eventos_formateados,
			'regalos' => $regalos
		]);
	}
}
