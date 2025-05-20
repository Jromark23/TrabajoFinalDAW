<?php

namespace Controllers;

use Model\Paquete;
use Model\Usuario;
use Model\Registro;
use MVC\Router;
use Intervention\Image\ImageManagerStatic as Image;

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

		// Si ya esta registrado en este tipo, le mostramos su entrada para 
		if(isset($registro) && $registro->paquete_id === '3') {
			// urlencode evita caracteres especiales
			header('Location: /entrada?id=' . urlencode($registro->token));
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
		}
	}

	public static function entrada(Router $router)
	{
		$id = $_GET['id'];
		//debuguear($id);

		if (!$id || strlen($id) !== 8) {
			header('Location: /5555555555');
			exit;
		}

		$registro = Registro::where('token', $id);

		$registro->usuario = Usuario::find($registro->usuario_id);
		$registro->paquete = Paquete::find($registro->paquete_id);

		//debuguear($registro);

		if (!$registro) {
			header('Location: /');
			exit;
		}

		$router->renderizar('registro/entrada', [
			'titulo' => 'Asistencia al evento',
			'registro' => $registro
		]);
	}
}
