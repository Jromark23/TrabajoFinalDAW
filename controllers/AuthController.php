<?php

namespace Controllers;

use Classes\Email;
use Model\Usuario;
use MVC\Router;
use DateTime;

class AuthController
{
	public static function login(Router $router)
	{
		// si ya esta logado, no puede volver a login 
		if (is_user()) {
			header('Location: /');
			exit;
		}

		// Reiniciar las alertas al iniciar la petición
		$alertas = [];

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			validar_csrf();

			// Creamos un objeto Usuario con los datos del formulario
			$usuarioFormulario = new Usuario($_POST);
			// Validamos campos obligatorios (email y password)
			$alertas = $usuarioFormulario->validarLogin();

			if (empty($alertas)) {
				// Buscamos en la base de datos un usuario con ese email
				$usuario = Usuario::where('email', $usuarioFormulario->email);

				if (!$usuario || !$usuario->confirmado) {
					// Si no existe el usuario o no está confirmado, mostramos alerta
					Usuario::setAlerta('error', 'El usuario no existe o no está confirmado');
					$alertas = Usuario::getAlertas();
				} else {
					// Comprobamos si supera los 5 intentos fallidos en 30 minutos
					$ahora       = new DateTime();
					// si hay un ultimo intento, lo convierte en fecha
					$ultimo      = $usuario->ultimo_intento ? new DateTime($usuario->ultimo_intento) : null;
					// si hay ultimo, calcula cuantos minutos han pasado 
					$minutosDif  = $ultimo ? ($ahora->getTimestamp() - $ultimo->getTimestamp()) / 60 : null;

					// Si "esta bloqueado", calculamos cuánto queda para desbloquear y mandamos el mensaje sin dejarle acceder
					if ($usuario->intentos_fallidos >= 5 && $minutosDif != null && $minutosDif < 30) {
						$minutosRestantes = max(0, 30 - floor($minutosDif));
						Usuario::setAlerta(
							'error',
							"Demasiados intentos. Vuelve a intentarlo en {$minutosRestantes} minutos o solicite una nueva contraseña."
						);
						$alertas = Usuario::getAlertas();
					} else {
						// Si han pasado más de 30 minutos desde el último intento, reseteamos el contador
						if ($ultimo && $minutosDif != null && $minutosDif >= 30) {
							$usuario->intentos_fallidos = 0;
							$usuario->ultimo_intento    = null;
							$usuario->guardar();
						}

						// Verificamos la contraseña 
						if (password_verify($_POST['password'], $usuario->password)) {
							// Contraseña correcta: reseteamos contador de fallos
							$usuario->intentos_fallidos = 0;
							$usuario->ultimo_intento    = null;
							$usuario->guardar();

							// Rotamos el ID de sesión por seguridad
							session_regenerate_id(true);

							// Guardamos la información mínima del usuario en sesión
							$_SESSION['id']       = $usuario->id;
							$_SESSION['nombre']   = $usuario->nombre;
							$_SESSION['apellido'] = $usuario->apellido;
							$_SESSION['email']    = $usuario->email;
							$_SESSION['admin']    = $usuario->admin ?? null;

							// Redirigimos según el rol
							if ($usuario->admin) {
								header('Location: /admin/dashboard');
								exit;
							} else {
								header('Location: /finalizar');
								exit;
							}
						} else {
							// Contraseña incorrecta: incrementamos contador de fallos y marcamos hora
							$usuario->intentos_fallidos++;
							$usuario->ultimo_intento = date('Y-m-d H:i:s');
							$usuario->guardar();

							Usuario::setAlerta('error', 'Contraseña incorrecta');
							$alertas = Usuario::getAlertas();
						}
					}
				}
			}
		}

		// Renderizar la vista de login, pasando todas las alertas (si las hay)
		$router->renderizar('auth/login', [
			'titulo'  => 'Iniciar Sesión',
			'alertas' => $alertas
		]);
	}



	public static function logout()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			validar_csrf();
			$_SESSION = [];
			session_destroy();
			header('Location: /');
			exit;
		}
	}

	public static function registro(Router $router)
	{
		// si ya esta logado, le mandamos a la pagina de comprar o a su entrada
		if (is_user()) {
			header('Location: /finalizar');
			exit;
		}
		$alertas = [];
		$usuario = new Usuario;

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			validar_csrf();
			//debuguear($_POST);

			$usuario->sincronizar($_POST);

			$alertas = $usuario->validar_cuenta();

			if (empty($alertas)) {
				$existeUsuario = Usuario::where('email', $usuario->email);

				if ($existeUsuario) {
					Usuario::setAlerta('error', 'El usuario ya está registrado');
					$alertas = Usuario::getAlertas();
				} else {
					// Hashear el password
					$usuario->hashPassword();

					// Eliminar password2
					unset($usuario->password2);

					// Generar el Token
					$usuario->crearToken();
					// Ponemos al token 30 minutos mas que la hora actual
					$usuario->token_expiracion = date('Y-m-d H:i:s', strtotime('+30 minutes'));

					// Crear un nuevo usuario
					$resultado =  $usuario->guardar();

					// Enviar email
					$email = new Email($usuario->email, $usuario->nombre, $usuario->token);
					error_log("Antes de enviarConfirmacion()");
					$email->enviarConfirmacion();
					error_log("Después de enviarConfirmacion()");



					if ($resultado) {
						header('Location: /mensaje');
						exit;
					}
				}
			}
		}

		// Render a la vista
		$router->renderizar('auth/registro', [
			'titulo' => 'Crea tu cuenta',
			'usuario' => $usuario,
			'alertas' => $alertas
		]);
	}

	public static function olvide(Router $router)
	{
		$alertas = [];

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			validar_csrf();

			$usuario = new Usuario($_POST);
			$alertas = $usuario->validarEmail();

			if (empty($alertas)) {
				// Buscar el usuario
				$usuario = Usuario::where('email', $usuario->email);

				if ($usuario && $usuario->confirmado) {

					// Generar un nuevo token
					$usuario->crearToken();
					// Ponemos al token 30 minutos mas que la hora actual
					$usuario->token_expiracion = date('Y-m-d H:i:s', strtotime('+30 minutes'));

					unset($usuario->password2);

					// Actualizar el usuario
					$usuario->guardar();

					// Enviar el email
					$email = new Email($usuario->email, $usuario->nombre, $usuario->token);
					$email->enviarInstrucciones();


					// Imprimir la alerta
					Usuario::setAlerta('exito', 'Hemos enviado las instrucciones a tu email');
					$alertas = Usuario::getAlertas();

					//$alertas['exito'][] = 'Hemos enviado las instrucciones a tu email';
				} else {

					// Usuario::setAlerta('error', 'El Usuario no existe o no esta confirmado');

					//$alertas['error'][] = 'El Usuario no existe o no esta confirmado';
					Usuario::setAlerta('error', 'El Usuario no existe o no esta confirmado');
					$alertas = Usuario::getAlertas();
				}
			}
		}

		// Muestra la vista
		$router->renderizar('auth/olvide', [
			'titulo' => 'Olvidé mi contraseña',
			'alertas' => $alertas
		]);
	}

	public static function reestablecer(Router $router)
	{
		// Recogemos el token y lo sanitizamos
		$token = sanitizeHtml($_GET['token'] ?? '');

		$token_valido = true;

		// Si no llega ninguno, vamos a inicio
		if (!$token) {
			header('Location: /');
			exit;
		}

		// Buscamos el usuario
		$usuario = Usuario::where('token', $token);

		// Si no existe, mostramos alerta y marcamos token como inválido
		if (!$usuario) {
			Usuario::setAlerta('error', 'Token no válido, intenta de nuevo');
			$alertas = Usuario::getAlertas();
			$token_valido = false;
		} else {
			// Si existe el usuario, comprobamos si el token ya expiró
			if ($usuario->token_expiracion && strtotime($usuario->token_expiracion) < time()) {
				// El token ya pasó su fecha de expiración
				Usuario::setAlerta('error', 'El enlace de recuperación ha expirado. Solicita uno nuevo.');
				$alertas = Usuario::getAlertas();
				$token_valido = false;
			}
		}


		if ($_SERVER['REQUEST_METHOD'] === 'POST' && $token_valido) {

			validar_csrf();

			$usuario->sincronizar($_POST);
			$alertas = $usuario->validarPassword();

			// Si no hay errores de validacion reestablecemos la contraseña 
			if (empty($alertas)) {
				// Hasheamos la nueva contraseña para guardarla hasehada
				$usuario->hashPassword();

				// Limpiamos el token y la fecha, asi como los intentos fallidos y nuevo intento
				$usuario->token = null;
				$usuario->token_expiracion = null;
				$usuario->intentos_fallidos = 0;
				$usuario->ultimo_intento    = null;

				$resultado = $usuario->guardar();

				if ($resultado) {
					header('Location: /login');
					exit;
				}
			}
		}

		// Si llegamos aquí, recuperamos todas las alertas (si las hay) antes de renderizar
		$alertas = Usuario::getAlertas();

		// Mostrar la vista de reestablecer contraseña, indicando si el token es válido o no
		$router->renderizar('auth/reestablecer', [
			'titulo'       => 'Reestablecer contraseña',
			'alertas'      => $alertas,
			'token_valido' => $token_valido
		]);
	}


	public static function mensaje(Router $router)
	{

		$router->renderizar('auth/mensaje', [
			'titulo' => 'Cuenta creada con éxito'
		]);
	}

	public static function confirmar(Router $router)
	{

		$token = sanitizeHtml($_GET['token']) ?? null;

		if (!$token) {
			header('Location: /');
			exit;
		}

		// Encontrar al usuario con este token
		$usuario = Usuario::where('token', $token);

		if (empty($usuario)) {
			// No se encontró un usuario con ese token
			Usuario::setAlerta('error', 'Token no válido');
			$alertas = Usuario::getAlertas();
		} else {
			// Verifica si el token ha expirado
			if ($usuario->token_expiracion && strtotime($usuario->token_expiracion) < time()) {

				Usuario::setAlerta('error', 'El enlace de confirmación ha expirado. Solicita uno nuevo.');
				$alertas = Usuario::getAlertas();
			} else {
				// El token es válido: confirmamos la cuenta
				$usuario->confirmado = 1;
				// Limpiamos campos de token y expiración
				$usuario->token = null;
				$usuario->token_expiracion = null;
				$usuario->guardar();

				Usuario::setAlerta('exito', 'Cuenta confirmada con éxito');
				$alertas = Usuario::getAlertas();
			}
		}
		$router->renderizar('auth/confirmar', [
			'titulo' => 'Confirma tu cuenta',
			'alertas' => $alertas
		]);
	}
}
