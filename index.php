<?php
session_set_cookie_params([
	'lifetime' => 0,
	'path'     => '/',
	//'secure'   => true, // Solo se enviara si es HTTPS
	'secure'   => false,  // ELIMINAR EN PROD
	'httponly' => true,   // No permite entrar por JavaScript, preveniendo ataques XSS
	'samesite' => 'Lax'	  // Se envia en navegaciones normales pero no en POST o scripts
]);

// 		 ARRANCAR SESIÓN Y CREAR TOKEN CSRF, asegurarnos de no reiniciarla
if (session_status() === PHP_SESSION_NONE) {
	session_start();
}
// Si aún no existe el token en la sesión, lo generamos
if (empty($_SESSION['csrf_token'])) {
	$_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

require_once __DIR__ . '/includes/app.php';

use MVC\Router;
use Controllers\AuthController;
use Controllers\DashboardController;
use Controllers\PonentesController;
use Controllers\EventosController;
use Controllers\UsuariosController;
use Controllers\RegalosController;
use Controllers\APIeventos;
use Controllers\APIponentes;
use Controllers\APIregalos;
use Controllers\PaginasController;
use Controllers\RegistroController;

$router = new Router();


// Login
$router->get('/login', [AuthController::class, 'login']);
$router->post('/login', [AuthController::class, 'login']);
$router->post('/logout', callback: [AuthController::class, 'logout']);

// Crear Cuenta
$router->get('/registro', [AuthController::class, 'registro']);
$router->post('/registro', [AuthController::class, 'registro']);

// Formulario de olvide mi password
$router->get('/olvide', [AuthController::class, 'olvide']);
$router->post('/olvide', [AuthController::class, 'olvide']);

// Nueva contraseña
$router->get('/reestablecer', [AuthController::class, 'reestablecer']);
$router->post('/reestablecer', [AuthController::class, 'reestablecer']);

// Confirmación de Cuenta
$router->get('/mensaje', [AuthController::class, 'mensaje']);
$router->get('/confirmar-cuenta', [AuthController::class, 'confirmar']);

// Administración
$router->get('/admin/dashboard', [DashboardController::class, 'index']);

// Ponentes
$router->get('/admin/ponentes', [PonentesController::class, 'index']);
$router->get('/admin/ponentes/crear', [PonentesController::class, 'crear']);
$router->post('/admin/ponentes/crear', [PonentesController::class, 'crear']);
$router->get('/admin/ponentes/editar', [PonentesController::class, 'editar']);
$router->post('/admin/ponentes/editar', [PonentesController::class, 'editar']);
$router->post('/admin/ponentes/eliminar', [PonentesController::class, 'eliminar']);



$router->get('/admin/eventos', [EventosController::class, 'index']);
$router->get('/admin/eventos/crear', [EventosController::class, 'crear']);
$router->post('/admin/eventos/crear', [EventosController::class, 'crear']);
$router->get('/admin/eventos/editar', [EventosController::class, 'editar']);
$router->post('/admin/eventos/editar', [EventosController::class, 'editar']);
$router->post('/admin/eventos/eliminar', [EventosController::class, 'eliminar']);

$router->get('/api/horarios-eventos', [APIeventos::class, 'index']);
$router->get('/api/ponentes', [APIponentes::class, 'index']);
$router->get('/api/ponente', [APIponentes::class, 'ponente']);
$router->get('/api/regalos', [APIregalos::class, 'index']);


$router->get('/admin/usuarios', [UsuariosController::class, 'index']);

$router->get('/admin/regalos', [RegalosController::class, 'index']);

// Zona frontend
$router->get('/', [PaginasController::class, 'index']);
$router->get('/nosotros', [PaginasController::class, 'nosotros']);
$router->get('/entradas', [PaginasController::class, 'entradas']);
$router->get('/eventos', [PaginasController::class, 'eventos']);
$router->get('/talleres', [PaginasController::class, 'talleres']);   // aqui 
$router->get('/404', [PaginasController::class, 'error']);
$router->get('/politica-cookies', [PaginasController::class, 'politicaCookies']);
$router->get('/politica-privacidad', [PaginasController::class, 'politicaPrivacidad']);

// Registro usuarios
$router->get('/finalizar', [RegistroController::class, 'crear']);
$router->get('/entrada', [RegistroController::class, 'entrada']);
$router->post('/finalizar/basico', [RegistroController::class, 'basico']);
$router->post('/finalizar/virtual', [RegistroController::class, 'virtual']);
$router->post('/finalizar/presencial', [RegistroController::class, 'presencial']);

$router->post('/finalizar/pagar', [RegistroController::class, 'pagar']);
$router->get('/finalizar/conferencias', [RegistroController::class, 'conferencias']);
$router->post('/finalizar/conferencias', [RegistroController::class, 'conferencias']);




// Comprueba la ruta en la que estamos y ejecuta el callback asociado
$router->comprobarRutas();
