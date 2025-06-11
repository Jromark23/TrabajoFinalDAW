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
use Classes\Email;
use Dompdf\Dompdf;
use Dompdf\Options;

require_once __DIR__ . '/../libs/phpqrcode/qrlib.php';


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
			validar_csrf();

			if (!is_user()) {
				header('Location: /login');
				exit;
			}
		}

		$token = substr(md5(uniqid(rand(), true)), 0, 8);
		//debuguear($token);

		$datos = [
			'paquete_id' => 3,
			'pago_id' => '',
			'token' => $token,
			'usuario_id' => $_SESSION['id']
		];

		$registro = new Registro($datos);
		$resultado = $registro->guardar();


		$urlVerificar = $_ENV['HOST'] . "/registro/validar?token={$token}";
		//$urlVerificar = "http://localhost:3000/registro/validar?token={$token}";

		$directorioQR = __DIR__ . '/../public/qrtemp/';
		if (!is_dir($directorioQR)) {
			mkdir($directorioQR, 0777, true);
		}

		$nombreArchivo = "qr_{$token}.png";
		$rutaCompleta  = $directorioQR . $nombreArchivo;

		\QRcode::png(
			$urlVerificar,  // Texto a codificar en el QR
			$rutaCompleta,  // Ruta donde se guarda el PNG
			QR_ECLEVEL_L,   // Nivel de corrección
			7,              // Tamaño del módulo
			2               // Margen
		);

		// Enviar el correo confirmando y con el QR 
		$usuario = Usuario::find($registro->usuario_id);
		if ($usuario) {

			$urlQrPublica = $_ENV['HOST'] . '/public/qrtemp/' . $nombreArchivo;

			$email = new \Classes\Email(
				$usuario->email,
				$usuario->nombre . ' ' . $usuario->apellido,
				$token
			);
			$email->enviarEntrada($urlQrPublica);
		} else {
			error_log("token={$token} ERROR en la compra basica");
		}

		if ($resultado) {

			// urlencode evita caracteres especiales
			header('Location: /entrada?id=' . urlencode($registro->token));
			exit;
		}
	}

	public static function premium(Router $router)
	{

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			validar_csrf();
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
			validar_csrf();
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
		$tokenEntrada = $_GET['id'] ?? null;
		//$session_id = $_SESSION['id'];

		// // Si hay un usuario logado, que tiene un registro le mandamos a la entrada 
		// $user = Usuario::find($session_id);
		// if($user) {
		// 	$registro = Registro::where('usuario_id', $user->id);	
		// 	if($registro->token) {
		// 		//debuguear($registro->token);
		// 		header('Location: /entrada?id=' . urlencode($registro->token));
		// 		exit;
		// 	}
		// }

		if (!$tokenEntrada || strlen($tokenEntrada) !== 8) {
			header('Location: /');
			exit;
		}

		$registro = Registro::where('token', $tokenEntrada);

		//debuguear($registro);

		if (!$registro) {
			header('Location: /');
			exit;
		}


		$registro->usuario = Usuario::find($registro->usuario_id);
		$registro->paquete = Paquete::find($registro->paquete_id);

		// REVISAR para pro"
		//$urlVerificar = "https://joelroman.site/registro/validar?token={$tokenEntrada}";
		$urlVerificar = $_ENV['HOST'] . "/registro/validar?token={$tokenEntrada}";

		// Donde ira el PNG temporal
		$directorioSalida = __DIR__ . '/../public/qrtemp/';

		if (!is_dir($directorioSalida)) {
			mkdir($directorioSalida, 0755, true);
		}

		$nombreArchivo = 'qr_' . $tokenEntrada . '.png';
		$rutaCompleta   = $directorioSalida . $nombreArchivo;


		// Necesita: ($data, $outfile, $level, $size, $margin)
		\QRcode::png(
			$urlVerificar,  // texto que hay que codificar
			$rutaCompleta,  // ruta donde guardar la imagen
			QR_ECLEVEL_L,   // nivel de corrección (L, M, Q, H)
			7,              // tamaño del QR
			2               // margen
		);

		// Convertir la imagen a datos Uri 
		$datosPng = file_get_contents($rutaCompleta);
		$qrDataUri = 'data:image/png;base64,' . base64_encode($datosPng);

		// Borrar el archivo temporal
		//unlink($rutaCompleta);

		//debuguear($urlVerificar);
		$router->renderizar('registro/entrada', [
			'titulo'    => 'Asistencia al evento',
			'registro'  => $registro,
			'qrDataUri' => $qrDataUri
		]);
	}

	public static function pagar(Router $router)
	{
		if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
			echo json_encode(['resultado' => false]);
			return;
		}

		if (!is_user()) {
			// Devolvemos false para que JS no de fallo, y redirigimos desde alli.
			echo json_encode(['resultado' => false]);
			return;
		}

		if (empty($_POST)) {
			echo json_encode(['resultado' => false]);
			return;
		}

		// Datos para registrar el pago 
		$datos = $_POST;
		$datos['token']      = substr(md5(uniqid(rand(), true)), 0, 8);
		$datos['usuario_id'] = $_SESSION['id'];

		try {
			// Crear y guardar el registro
			$registro  = new Registro($datos);
			$resultado = $registro->guardar(); // true o false

			if ($resultado) {
				// Generamos el QR y guardamos la imagen
				$tokenEntrada = $registro->token;

				$urlVerificar = $_ENV['HOST'] . "/registro/validar?token={$tokenEntrada}";
				$directorioQR = __DIR__ . '/../public/qrtemp/';
				if (!is_dir($directorioQR)) {
					mkdir($directorioQR, 0777, true);
				}

				$nombreArchivo = "qr_{$tokenEntrada}.png";
				$rutaCompleta  = $directorioQR . $nombreArchivo;

				\QRcode::png(
					$urlVerificar,
					$rutaCompleta,
					QR_ECLEVEL_L,
					7,
					2
				);

				// Enviar el correo solo si el paquete es 2 (premium)
				if (isset($registro->paquete_id) && $registro->paquete_id == 2) {
					$usuario = Usuario::find($registro->usuario_id);
					if ($usuario) {
						$urlQrPublica = $_ENV['HOST'] . '/public/qrtemp/' . $nombreArchivo;
						$email = new \Classes\Email(
							$usuario->email,
							$usuario->nombre . ' ' . $usuario->apellido,
							$tokenEntrada
						);
						$email->enviarEntrada($urlQrPublica);
					} else {
						error_log("Pago registrado (token={$tokenEntrada}) pero no se encontró usuario ID {$registro->usuario_id} para mandar el correo.");
					}
				}

				// mandamos el token y el true para evitar fallo de redireccion
				echo json_encode([
					'resultado' => true,
					'token'     => $tokenEntrada
				]);
				return;
			}

			// Si guardar falle, false
			echo json_encode(['resultado' => false]);
		} catch (\Throwable $th) {
			// Si falla la bbdd error 
			echo json_encode(['resultado' => 'error']);
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
		$eventoRegistro = EventosRegistros::where('registro_id', $registro->id);

		// Si no tiene registro no permitir el acceso a la web
		if (!isset($registro)) {
			header('Location: /');
		}

		// Si ya tiene evento asociado, mandarle a su entrada
		if ($eventoRegistro) {
			header('Location: /entrada?id=' . urlencode($registro->token));
		}


		// if ($registro->paquete_id) { 
		// 	header('Location: /entrada?id=' . urlencode($registro->token));
		// 	exit;
		// }



		// Si ya existe el registro y su paquete es virtual le mandamos a su entrada
		if ($registro->paquete_id === 2) {
			header('Location: /entrada?id=' . urlencode($registro->token));
			exit;
		}

		// Si el paquete no es presencial, le mandamos a inicio
		if ($registro->paquete_id === 3) {
			header('Location: /entrada?id=' . urlencode($registro->token));
			exit;
		}

		// // Si ya tiene el registro, redirigir a la entrada        REVISAR
		// if ($registro->paquete_id === 1) {
		// 	header('Location: /entrada?id=' . urlencode($registro->token));
		// 	exit;
		// }


		$eventos = Evento::whereOrden('hora_id', 'ASC');

		$eventos_formateados = [];

		foreach ($eventos as $evento) {

			$evento->categoria = Categoria::find($evento->categoria_id);
			$evento->dia_objeto = Dia::find($evento->dia_id);
			$evento->hora = Hora::find($evento->hora_id);
			$evento->ponente = Ponente::find($evento->ponente_id);

			//debuguear($evento);

			if ($evento->dia_id === 1 && $evento->categoria_id === 1) {
				$eventos_formateados['conferencia_v'][] = $evento;
			}
			if ($evento->dia_id === 2 && $evento->categoria_id === 1) {
				$eventos_formateados['conferencia_s'][] = $evento;
			}
			if ($evento->dia_id === 1 && $evento->categoria_id === 2) {
				$eventos_formateados['taller_v'][] = $evento;
			}
			if ($evento->dia_id === 2 && $evento->categoria_id === 2) {
				$eventos_formateados['taller_s'][] = $evento;
			}
		}

		$regalos = Regalo::all('ASC');

		// Registro
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			//validar_csrf();

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
			//debuguear($usuario->paquete_id);
			if (!isset($usuario) || $usuario->paquete_id !== 1) {
				echo json_encode(['resultado' => false]);
				exit;
			}

			$eventos_aux = [];
			// Validar que quedan entradas 
			foreach ($eventos as $evento_id) {
				$evento = Evento::find($evento_id);

				if (!isset($evento) || $evento->disponibles === 0) {
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

			// Enviar correo solo si el paquete es 1 (presencial) y el registro fue exitoso
			if ($resultado && $registro->paquete_id == 1) {
				$nombreArchivo = "qr_{$registro->token}.png";
				$urlQrPublica = $_ENV['HOST'] . '/public/qrtemp/' . $nombreArchivo;
				$usuario = Usuario::find($registro->usuario_id);
				if ($usuario) {
					$email = new \Classes\Email(
						$usuario->email,
						$usuario->nombre . ' ' . $usuario->apellido,
						$registro->token
					);
					$email->enviarEntrada($urlQrPublica);
				}
			}

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
			'titulo' => 'Eventos disponibles',
			'eventos' => $eventos_formateados,
			'regalos' => $regalos
		]);
	}

	public static function validar(Router $router)
	{
		// Obtenemos el tokek de la entrada
		$token = $_GET['token'] ?? null;

		// validamos formato
		if (!$token || strlen($token) !== 8) {
			$mensaje = "Token no válido o vacio.";
			// Renderizamos la vista con mensaje de error
			$router->renderizar('registro/validado', [
				'titulo'  => 'Validación de entrada',
				'mensaje' => $mensaje,
				'tipo'    => 'error'
			]);
			return;
		}

		// Si va bien, buscamos el registro con ese token 
		$registro = Registro::where('token', $token);

		if (!$registro) {
			// No existe entrada con ese token
			$mensaje = "No se encontró ningún ticket con ese código.";
			$router->renderizar('registro/validado', [
				'titulo'  => 'Validación de entrada',
				'mensaje' => $mensaje,
				'tipo'    => 'error'
			]);
			return;
		}

		// Comprobamos si ha sido validada previamente
		if ($registro->validado) {
			$mensaje = "Esta entrada ya ha sido validada.";
			$router->renderizar('registro/validado', [
				'titulo'  => 'Validación de entrada',
				'mensaje' => $mensaje,
				'tipo'    => 'error'
			]);
			return;
		}

		// Marcar como validado y guardar en base de datos
		$registro->validado = 1;
		$registro->guardar();

		// Mostrar mensaje de exito
		$mensaje = "¡Entrada validada con éxito! Bienvenido al evento.";
		$router->renderizar('registro/validado', [
			'titulo'  => 'Validación de entrada',
			'mensaje' => $mensaje,
			'tipo'    => 'success'
		]);
	}

	public static function descargarPDF(Router $router)
	{
		// Obtenemos el token
		$token = $_GET['id'] ?? null;
		if (!$token || strlen($token) !== 8) {
			header('Location: /');
			exit;
		}

		// Buscamos el registro asociado
		$registro = Registro::where('token', $token);
		if (!$registro) {
			header('Location: /');
			exit;
		}

		// Buscamos el usuario 
		$registro->usuario = Usuario::find($registro->usuario_id);
		$registro->paquete = Paquete::find($registro->paquete_id);

		// Buscamos el QR, si no, lo generamos de nuevo 
		$nombreArchivo = "qr_{$token}.png";
		$rutaQR        = __DIR__ . '/../public/qrtemp/' . $nombreArchivo;
		if (!file_exists($rutaQR)) {
			$urlVerificar = $_ENV['HOST'] . "/registro/validar?token={$token}";
			\QRcode::png($urlVerificar, $rutaQR, QR_ECLEVEL_L, 7, 2);
		}

		$imgData   = base64_encode(file_get_contents($rutaQR));
		$qrDataUri = 'data:image/png;base64,' . $imgData;

		$html = '
				<html>
				<head>
					<meta charset="UTF-8" />
					<style>
					body { font-family: DejaVu Sans, sans-serif; }
					.contenedor { text-align: center; margin-top: 50px; }
					.titulo { font-size: 24px; margin-bottom: 20px; }
					.detalle { font-size: 18px; margin-bottom: 40px; }
					.qr img { width: 200px; height: 200px; }
					</style>
				</head>
				<body>
					<div class="contenedor">
					<div class="titulo">Entrada al evento</div>
					<div class="detalle">
						<strong>Nombre:</strong><br>
						' . htmlspecialchars($registro->usuario->nombre . ' ' . $registro->usuario->apellido) . '<br><br>
						<strong>Paquete:</strong><br>
						' . htmlspecialchars($registro->paquete->nombre) . '<br><br>
						<strong>Código:</strong><br>
						#' . htmlspecialchars($registro->token) . '
					</div>
					<div class="qr">
						<img src="' . $qrDataUri . '" alt="Código QR">
					</div>
					</div>
				</body>
				</html>';

		$options = new \Dompdf\Options();
		$options->set('defaultFont', 'DejaVu Sans');
		$options->set('isRemoteEnabled', true);

		$dompdf = new \Dompdf\Dompdf($options);
		$dompdf->loadHtml($html);
		$dompdf->setPaper('A4', 'portrait');
		$dompdf->render();

		$nombrePDF = 'entrada_' . $registro->token . '.pdf';
		header('Content-Type: application/pdf');
		header('Content-Disposition: attachment; filename="' . $nombrePDF . '"');
		echo $dompdf->output();
		exit;
	}
}
