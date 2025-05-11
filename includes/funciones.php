<?php
// funcion que me ayuda a debuguear facilmente simplemente indicando la variable, y dandole formato con PRE
function debuguear($variable) : string {
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}

// funcion que me ayuda a evitar la insercion de codigo malicioso convirtiendo caracteres especiales 
function sanitizeHtml($html) : string {
    $s = htmlspecialchars($html);
    return $s;
}

// Comprueba si la URL actual contiene el texto indicado en $path (util para ver la parte seleccionada en el dashboard)
function pagina_actual($path) {
	return str_contains($_SERVER['PATH_INFO'], $path) ? true : false;
}

// Devuelve si hay usuario logado 
function is_user() : bool {
	session_start();

	return isset($_SESSION['nombre']) && !empty($_SESSION);
}

// Devuelve si el usuario logado actual es admin
function is_admin() : bool {
	session_start();

	return isset($_SESSION['admin']) && !empty($_SESSION['admin']);
}