<?php

namespace Controllers;

use Classes\Paginacion;
use Model\Ponente;
use MVC\Router;
use Intervention\Image\ImageManagerStatic as Image;

class PonentesController
{

	public static function index(Router $router)
	{
		if (!is_admin()) {
			header('Location: /login');
			exit;
		}
		// obtenemos numero de pagina y validamos
		$pagina_actual = $_GET['page'];
		$pagina_actual = filter_var($pagina_actual, FILTER_VALIDATE_INT);

		// si no es valido, dirigimos a la 1 
		if (!$pagina_actual || $pagina_actual < 1) {
			header('Location: /admin/ponentes?page=1');
			exit;
		}

		$registros_pagina = 6;
		$total_registros = Ponente::count();
		$paginacion = new Paginacion($pagina_actual, $registros_pagina, $total_registros);

		if ($paginacion->total_paginas() < $pagina_actual) {
			header('Location: /admin/ponentes?page=1');
			exit;
		}

		$ponentes = Ponente::paginar($registros_pagina, $paginacion->offset());

		if (!is_admin()) {
			header('Location: /login');
			exit;
		}

		$router->renderizar('admin/ponentes/index', [
			'titulo' => 'Ponentes',
			'ponentes' => $ponentes,
			'paginacion' => $paginacion->paginacion()
		]);
	}

	public static function crear(Router $router)
	{
		if (!is_admin()) {
			header('Location /login');
			exit;
		}
		$alertas = [];
		$ponente = new Ponente;

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			// Comprobar que venga la imagen
			if (!empty($_FILES['imagen']['tmp_name'])) {
				$img_folder = '../public/img/speakers';
				// Si no existe, crea la carpeta
				if (!is_dir($img_folder)) {
					mkdir($img_folder, 0777, true);
				}

				//Formatea la imagen al formato y tamaño dados
				$img_png = Image::make($_FILES['imagen']['tmp_name'])->fit(800, 800)->encode('png', 80);
				$img_webp = Image::make($_FILES['imagen']['tmp_name'])->fit(800, 800)->encode('webp', 80);

				// Genera un nombre aleatorio para la imagen basado en microsegundos, random y lo hashea md5
				$nombre_imagen = md5(uniqid(rand(), true));

				$_POST['imagen'] = $nombre_imagen;
			}

			// sanitizamos el array para que no de error y escapamos las \
			$_POST['rrss'] = json_encode($_POST['rrss'], JSON_UNESCAPED_SLASHES);

			$ponente->sincronizar($_POST);
			$alertas = $ponente->validar();

			// Guarda el registro
			if (empty($alertas)) {
				$img_png->save($img_folder . '/' . $nombre_imagen . ".png");
				$img_webp->save($img_folder . '/' . $nombre_imagen . ".webp");

				// Insertar en la BBDD
				$resultado = $ponente->guardar();

				if ($resultado) {
					header('Location: /admin/ponentes');
					exit;
				}
			}
		}

		$router->renderizar('admin/ponentes/crear', [
			'titulo' => 'Registrar ponente',
			'alertas' => $alertas,
			'ponente' => $ponente,
			'rrss' => json_decode($ponente->rrss)
		]);
	}

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
			header('Location: /admin/ponentes');
			exit;
		}

		//Obtenerlo y mandarlo a editar
		$ponente = Ponente::find($id);
		if (!$ponente) {
			header('Location: /admin/ponentes');
			exit;
		}

		$ponente->img_actual = $ponente->imagen;

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			if (!is_admin()) {
				header('Location: /login');
				exit;
			}

			// Comprobar si hay imagen
			if (!empty($_FILES['imagen']['tmp_name'])) {
				$img_folder = '../public/img/speakers';
				// Si no existe, crea la carpeta
				if (!is_dir($img_folder)) {
					mkdir($img_folder, 0777, true);
				}

				//Formatea la imagen al formato y tamaño dados
				$img_png = Image::make($_FILES['imagen']['tmp_name'])->fit(800, 800)->encode('png', 80);
				$img_webp = Image::make($_FILES['imagen']['tmp_name'])->fit(800, 800)->encode('webp', 80);

				// Genera un nombre aleatorio para la imagen basado en microsegundos, random y lo hashea md5
				$nombre_imagen = md5(uniqid(rand(), true));

				$_POST['imagen'] = $nombre_imagen;
			} else {
				$_POST['imagen'] = $ponente->img_actual;
			}

			$_POST['rrss'] = json_encode($_POST['rrss'], JSON_UNESCAPED_SLASHES);
			$ponente->sincronizar($_POST);
			$alertas = $ponente->validar();

			if (empty($alertas)) {
				if (isset($nombre_imagen)) {
					$img_png->save($img_folder . '/' . $nombre_imagen . ".png");
					$img_webp->save($img_folder . '/' . $nombre_imagen . ".webp");
				}

				$resultado = $ponente->guardar();
				if ($resultado) {
					header('Location: /admin/ponentes');
					exit;
				}
			}
		}

		$router->renderizar('admin/ponentes/editar', [
			'titulo' => 'Actualizar ponente',
			'alertas' => $alertas,
			'ponente' => $ponente,
			'rrss' => json_decode($ponente->rrss)
		]);
	}

	public static function eliminar(Router $router)
	{
		if (!is_admin()) {
			header('Location /login');
			exit;
		}
		$alertas = [];


		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$id = $_POST['id'];

			$ponente = Ponente::find($id);
			if (!isset($ponente)) {
				header('Location: /admin/ponentes');
				exit;
			}
			$resultado = $ponente->eliminar();

			if ($resultado) {
				header('Location: /admin/ponentes');
				exit;
			}
		}
	}
}
