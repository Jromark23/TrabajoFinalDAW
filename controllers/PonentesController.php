<?php

namespace Controllers;

use Classes\Paginacion;
use Model\Ponente;
use MVC\Router;
use Intervention\Image\ImageManagerStatic as Image;

/**
 * Controlador para la gestión de ponentes en el panel de administración.
 */
class PonentesController
{
    /**
     * Muestra la lista paginada de ponentes.
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

		$router->renderizar('admin/ponentes/index', [
			'titulo' => 'Ponentes',
			'ponentes' => $ponentes,
			'paginacion' => $paginacion->paginacion()
		]);
	}

    /**
     * Muestra el formulario para crear un nuevo ponente y procesa su registro.
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
		$ponente = new Ponente;






		/*
		*     VALIDACION DE LAS IMAGENES
		*/

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			validar_csrf();

			// Comprobar que venga la imagen
			if (!empty($_FILES['imagen']['tmp_name'])) {

				// VALIDAR TAMAÑO MÁXIMO 
				$maxSize = 2 * 1024 * 1024; // 2MB en bytes
				if ($_FILES['imagen']['size'] > $maxSize) {
					Ponente::setAlerta('error', 'La imagen no puede superar los 2 MB.');
					// Renderizar la vista con alertas y terminar la ejecución
					$router->renderizar('admin/ponentes/crear', [
						'titulo'   => 'Registrar ponente',
						'alertas'  => Ponente::getAlertas(),
						'ponente'  => new Ponente,
						'rrss'     => json_decode(json_encode([]))
					]);
					return;
				}

				// Validar tipos solo aceptar JPG o PNG
				$info = getimagesize($_FILES['imagen']['tmp_name']);
				if (!$info || ($info[2] !== IMAGETYPE_JPEG && $info[2] !== IMAGETYPE_PNG)) {
					Ponente::setAlerta('error', 'Solo se permiten imágenes en formato JPG o PNG.');
					$router->renderizar('admin/ponentes/crear', [
						'titulo'   => 'Registrar ponente',
						'alertas'  => Ponente::getAlertas(),
						'ponente'  => new Ponente,
						'rrss'     => json_decode(json_encode([]))
					]);
					return;
				}


				// $img_folder = '../img/speakers';
				$img_folder = __DIR__ . '/../public/build/img/speakers';

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

    /**
     * Muestra el formulario para editar un ponente y procesa la actualización.
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

			validar_csrf();

			if (!is_admin()) {
				header('Location: /login');
				exit;
			}

			// Comprobar si hay imagen
			if (!empty($_FILES['imagen']['tmp_name'])) {


				// Validar el tamaño maximo 
				$maxSize = 2 * 1024 * 1024;
				if ($_FILES['imagen']['size'] > $maxSize) {
					Ponente::setAlerta('error', 'La imagen no puede superar los 2 MB.');
					$router->renderizar('admin/ponentes/crear', [
						'titulo'   => 'Registrar ponente',
						'alertas'  => Ponente::getAlertas(),
						'ponente'  => new Ponente,
						'rrss'     => json_decode(json_encode([]))
					]);
					return;
				}

				// Validar tipos solo aceptar JPG o PNG
				$info = getimagesize($_FILES['imagen']['tmp_name']);
				if (!$info || ($info[2] !== IMAGETYPE_JPEG && $info[2] !== IMAGETYPE_PNG)) {
					Ponente::setAlerta('error', 'Solo se permiten imágenes en formato JPG o PNG.');
					$router->renderizar('admin/ponentes/crear', [
						'titulo'   => 'Registrar ponente',
						'alertas'  => Ponente::getAlertas(),
						'ponente'  => new Ponente,
						'rrss'     => json_decode(json_encode([]))
					]);
					return;
				}
				
				//$img_folder = '/img/speakers';
				$img_folder = __DIR__ . '/../public/build/img/speakers';


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

    /**
     * Elimina un ponente seleccionado.
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
