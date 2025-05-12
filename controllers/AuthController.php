<?php

namespace Controllers;

use Classes\Email;
use Model\Usuario;
use MVC\Router;

class AuthController
{
	public static function login(Router $router)
	{

		$alertas = [];

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			$usuario = new Usuario($_POST);

			$alertas = $usuario->validarLogin();

			if (empty($alertas)) {
				// Verificar quel el usuario exista
				$usuario = Usuario::where('email', $usuario->email);
				if (!$usuario || !$usuario->confirmado) {
					Usuario::setAlerta('error', 'El usuario no existe o no esta confirmado');
				} else {
					// El usuario existe
					if (password_verify($_POST['password'], $usuario->password)) {

						// Configurar la cookie de sesión para que muera al cerrar navegador y sea valida en toda la web
						session_set_cookie_params([
							'lifetime' => 0,
							'path' => '/'
						]);
						// Iniciar la sesión
						session_start();

						// Regenerar ID de sesión para evitar que quede guardada
						session_regenerate_id(true);

						$_SESSION['id'] = $usuario->id;
						$_SESSION['nombre'] = $usuario->nombre;
						$_SESSION['apellido'] = $usuario->apellido;
						$_SESSION['email'] = $usuario->email;
						$_SESSION['admin'] = $usuario->admin ?? null;

						// Redireccion admin o user
						if ($usuario->admin) {
							header('Location: /admin/dashboard');
							exit;
						} else {
							header('Location: /finalizar-registro');
							exit;
						}
					} else {
						Usuario::setAlerta('error', 'Contraseña incorrecta');
					}
				}
			}
		}

		$alertas = Usuario::getAlertas();

		// Render a la vista 
		$router->renderizar('auth/login', [
			'titulo' => 'Iniciar Sesión',
			'alertas' => $alertas
		]);
	}

	public static function logout()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			session_start();
			$_SESSION = [];
			header('Location: /');
			exit;
		}
	}

	public static function registro(Router $router)
	{
		$alertas = [];
		$usuario = new Usuario;

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

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

					// Crear un nuevo usuario
					$resultado =  $usuario->guardar();

					// Enviar email
					$email = new Email($usuario->email, $usuario->nombre, $usuario->token);
					$email->enviarConfirmacion();


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
			$usuario = new Usuario($_POST);
			$alertas = $usuario->validarEmail();

			if (empty($alertas)) {
				// Buscar el usuario
				$usuario = Usuario::where('email', $usuario->email);

				if ($usuario && $usuario->confirmado) {

					// Generar un nuevo token
					$usuario->crearToken();
					unset($usuario->password2);

					// Actualizar el usuario
					$usuario->guardar();

					// Enviar el email
					$email = new Email($usuario->email, $usuario->nombre, $usuario->token);
					$email->enviarInstrucciones();


					// Imprimir la alerta
					// Usuario::setAlerta('exito', 'Hemos enviado las instrucciones a tu email');

					$alertas['exito'][] = 'Hemos enviado las instrucciones a tu email';
				} else {

					// Usuario::setAlerta('error', 'El Usuario no existe o no esta confirmado');

					$alertas['error'][] = 'El Usuario no existe o no esta confirmado';
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

		$token = sanitizeHtml($_GET['token']);

		$token_valido = true;

		if (!$token) {
			header('Location: /');
			exit;
		}

		// Identificar el usuario con este token
		$usuario = Usuario::where('token', $token);

		if (empty($usuario)) {
			Usuario::setAlerta('error', 'Token no válido, intenta de nuevo');
			$token_valido = false;
		}


		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			// Añadir el nuevo password
			$usuario->sincronizar($_POST);

			// Validar el password
			$alertas = $usuario->validarPassword();

			if (empty($alertas)) {
				// Hashear el nuevo password
				$usuario->hashPassword();

				// Eliminar el Token
				$usuario->token = null;

				// Guardar el usuario en la BD
				$resultado = $usuario->guardar();

				// Redireccionar a iniciar sesion
				if ($resultado) {
					header('Location: /login');
					exit;
				}
			}
		}

		$alertas = Usuario::getAlertas();

		// Muestra la vista
		$router->renderizar('auth/reestablecer', [
			'titulo' => 'Reestablecer contraseña',
			'alertas' => $alertas,
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

		$token = sanitizeHtml($_GET['token']);

		if (!$token) {
			header('Location: /');
			exit;
		}

		// Encontrar al usuario con este token
		$usuario = Usuario::where('token', $token);

		if (empty($usuario)) {
			// No se encontró un usuario con ese token
			Usuario::setAlerta('error', 'Token no válido');
		} else {
			// Confirmar la cuenta
			$usuario->confirmado = 1;
			$usuario->token = '';
			unset($usuario->password2);

			// Guardar en la BD
			$usuario->guardar();

			Usuario::setAlerta('exito', 'Cuenta confirmada con éxito');
		}



		$router->renderizar('auth/confirmar', [
			'titulo' => 'Confirma tu cuenta',
			'alertas' => Usuario::getAlertas()
		]);
	}
}
