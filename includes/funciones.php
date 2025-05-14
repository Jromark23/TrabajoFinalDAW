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

// Compara si la pagina actual es igual o contiene lo que le pasamos (se usará para admin y para resaltar en la princiapl )
function pagina_actual($path) {
	return str_contains($_SERVER['PATH_INFO'] ?? '/', $path) ? true : false;
}

// Devuelve si hay usuario logado 
function is_user() : bool {

	if(!isset($_SESSION)) {
		session_start();
	}

	return isset($_SESSION['nombre']) && !empty($_SESSION);
}

// Devuelve si el usuario logado actual es admin
function is_admin() : bool {
	
	if(!isset($_SESSION)) {
		session_start();
	}

	return isset($_SESSION['admin']) && !empty($_SESSION['admin']);
}

// Funcion para la libreria AOS que ayuda a que haya animaciones random para usar
function animacion_aos() {

	$efectos = ['fade-up', 'fade-down','fade-left','fade-right','flip-left',
		'flip-right','zoom-in','zoom-in-up','zoom-in-down', 'zoom-out'];

	$efecto = array_rand($efectos, 1);
	return ' data-aos="' . $efectos[$efecto] . '" ';
}