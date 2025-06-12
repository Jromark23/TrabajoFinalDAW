<?php

namespace MVC;
/**
 * Clase Router para gestionar las rutas de la aplicación
 */
class Router
{
    // Array para almacenar rutas GET
    public array $getRoutes = [];
    // Array para almacenar rutas POST
    public array $postRoutes = [];

    // Método para registrar una ruta GET
    public function get($url, $callback)
    {
        $this->getRoutes[$url] = $callback;
    }

    // Método para registrar una ruta POST
    public function post($url, $callback)
    {
        $this->postRoutes[$url] = $callback;
    }

	// Comprueba la ruta actual y ejecuta el callback correspondiente
    public function comprobarRutas()
    {
		// Recupera la URL actual de la petición o '/' si no existe
        $url_actual = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? '/';
        // Recupera el método HTTP (GET o POST)
        $method = $_SERVER['REQUEST_METHOD'];

		// Selecciona el callback correspondiente según el método
        if ($method === 'GET') {
            $callback = $this->getRoutes[$url_actual] ?? null;
        } else {
            $callback = $this->postRoutes[$url_actual] ?? null;
        }

		// Si existe un callback, lo ejecuta. Si no, redirige a la página 404
		// callback es la función que se asocia a la ruta
		// $router->get('/login', [AuthController::class, 'login']);
        if ( $callback ) {
            call_user_func($callback, $this);
        } else {
            header('Location: /404');
			exit;
        }
    }


	// Recibe la vista y todos los datos que necesitemos pasarle
	public function renderizar($view, $datos = [])
    {
        // Extrae cada elemento del array $datos como una variable nueva. Variable variable
        foreach ($datos as $key => $value) {
            $$key = $value; 
        }

		// Inicia el almacenamiento en buffer de la salida
        ob_start(); 

        // Incluye la vista correspondiente
        include_once __DIR__ . "/views/$view.php";

		// Obtiene el contenido del buffer y lo limpia
        $contenido = ob_get_clean(); 

		// Recupera la URL actual
		$url_actual = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? '/';

		// Si la URL contiene 'admin', usa el layout de administradores
		if(str_contains($url_actual, '/admin')) {
			include_once __DIR__ . '/views/admin_layout.php';
		} else {
			// Si no, usa el layout general
			include_once __DIR__ . '/views/layout.php';
		}

    }
}
