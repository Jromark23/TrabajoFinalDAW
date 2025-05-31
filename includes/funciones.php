<?php
use Model\Usuario;

// funcion que me ayuda a debuguear facilmente simplemente indicando la variable, y dandole formato con PRE
function debuguear($variable): string
{
	echo "<pre>";
	var_dump($variable);
	echo "</pre>";
	exit;
}

// funcion que me ayuda a evitar la insercion de codigo malicioso convirtiendo caracteres especiales 
function sanitizeHtml($html): string
{
	$string = htmlspecialchars($html);
	return $string;
}

// Compara si la pagina actual es igual o contiene lo que le pasamos (se usará para admin y para resaltar en la princiapl )
function pagina_actual($path)
{
	return str_contains($_SERVER['PATH_INFO'] ?? '/', $path) ? true : false;
}

// Devuelve si hay usuario logado 
function is_user(): bool
{
	// Verificamos que la sesion tiene ID
    $userId = $_SESSION['id'] ?? null;

    if (!$userId) {
		return false;
    }
	
    // Comprobamos si corresponde a un usuario real
    $usuario = Usuario::find($userId);
    if (!$usuario) {
        return false;
    }

	
    return true;
}

// Devuelve si el usuario logado actual es admin
function is_admin(): bool
{
	// Comprobamos que hay usuario logado
    $userId = $_SESSION['id'] ?? null;
    if (!$userId) {
        return false;
    }

    // Si lo hay, lo buscamos en la base de datos 
    $usuario = Usuario::find($userId);

    if (!$usuario) {
        return false;
    }
	
    // Si en BD es admin devuelve true
    return ($usuario->admin == 1) ? true : false ;
}

// Funcion para la libreria AOS que ayuda a que haya animaciones random para usar
function animacion_aos()
{

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

function csrf(): string {
    $token = $_SESSION['csrf_token'] ?? '';
    
    $tokenEscapado = htmlspecialchars($token, ENT_QUOTES, 'UTF-8');
    return "<input type=\"hidden\" name=\"csrf_token\" value=\"{$tokenEscapado}\">";
}

