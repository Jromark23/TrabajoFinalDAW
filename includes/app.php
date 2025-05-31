<?php 

use Dotenv\Dotenv;
use Model\ActiveRecord;
require __DIR__ . '/../vendor/autoload.php';


session_set_cookie_params([
    'lifetime' => 0,
    'path'     => '/',
    //'secure'   => true,   // Solo se enviara si es HTTPS
	'secure'   => false,   // ELIMINAR EN PROD
    'httponly' => true,   // No permite entrar por JavaScript
    'samesite' => 'Lax'
]);

// 		 ARRANCAR SESIÓN Y CREAR TOKEN CSRF, asegurarnos de no reiniciarla
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// Si aún no existe el token en la sesión, lo generamos
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}



// Carga de manera segura las variables de .env
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

// traemos las funciones auxiliares del proyecto, y la base de datos
require __DIR__ . '/funciones.php';
require __DIR__ . '/database.php';

// Conectarnos a la base de datos
ActiveRecord::setDB($db);