<?php

use Model\Usuario;

/**
 * Debuguea con formato legible la variable proporcionada
 *
 * @param mixed $variable
 * @return string
 */
function debuguear($variable): string
{
	echo "<pre>";
	var_dump($variable);
	echo "</pre>";
	exit;
}

/**
 * Comprueba si la página actual contiene el path indicado.
 *
 * @param string $path Trozo de ruta a buscar en la URL actual.
 * @return bool
 */
function pagina_actual($path)
{
	return str_contains($_SERVER['PATH_INFO'] ?? '/', $path) ? true : false;
}

/**
 * Verifica si hay un usuario logado.
 *
 * @return bool
 */
function is_user(): bool
{
	$userId = $_SESSION['id'] ?? null;

	if (!$userId) {
		return false;
	}

	$usuario = Usuario::find($userId);
	if (!$usuario) {
		return false;
	}

	return true;
}

/**
 * Verifica si el usuario logado es admin.
 *
 * @return bool
 */
function is_admin(): bool
{
	$userId = $_SESSION['id'] ?? null;
	if (!$userId) {
		return false;
	}

	$usuario = Usuario::find($userId);

	if (!$usuario) {
		return false;
	}

	return ($usuario->admin == 1) ? true : false;
}

/**
 * Devuelve una funcion aleatoria de la libreria AOS de efectos.
 *
 * @return string Atributo "data-aos" con el efecto seleccionado.
 */
function animacion_aos()
{
	// Lista de efectos a usar
	$efectos = [
		'fade-up',
		'fade-down',
		'fade-left',
		'fade-right',
		'flip-left',
		'flip-right',
		'zoom-in',
		'zoom-in-up',
		'zoom-in-down',
		'zoom-out'
	];

	$efecto = array_rand($efectos, 1);
	return ' data-aos="' . $efectos[$efecto] . '" ';
}

/**
 * Genera un input hidden con el token CSRF de la sesión.
 *
 * @return string HTML del input con el token CSRF.
 */
function csrf(): string
{
	$token = $_SESSION['csrf_token'] ?? '';

	$tokenEscapado = htmlspecialchars($token, ENT_QUOTES, 'UTF-8');
	return "<input type=\"hidden\" name=\"csrf_token\" value=\"{$tokenEscapado}\">";
}

/**
 * Valida el token CSRF enviado por el formulario con el de la sesión.
 *
 * Usada cuando mandemos solicitudes POST.
 * Si el token no coincide devuelve un error 403 y para la ejecución.
 *
 * @return void
 */
function validar_csrf()
{
	$tokenForm = $_POST['csrf_token'] ?? '';
	$tokenSess = $_SESSION['csrf_token'] ?? '';
	if (!hash_equals($tokenSess, $tokenForm)) {
		http_response_code(403);
		exit('Error: token CSRF inválido.');
	}
}

