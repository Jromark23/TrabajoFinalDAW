<?php

namespace MVC;
/**
 * 
 */
class Router
{
    public array $getRoutes = [];
    public array $postRoutes = [];

    public function get($url, $callback)
    {
        $this->getRoutes[$url] = $callback;
    }

    public function post($url, $callback)
    {
        $this->postRoutes[$url] = $callback;
    }

	// Comprueba la ruta actual y ejecuta el callback correspondiente
    public function comprobarRutas()
    {
		// Recupera la URL y el METHOD por el que llega 
        $url_actual = $_SERVER['PATH_INFO'] ?? '/';
        $method = $_SERVER['REQUEST_METHOD'];

		// Añade el callback que corresponda si existe
        if ($method === 'GET') {
            $callback = $this->getRoutes[$url_actual] ?? null;
        } else {
            $callback = $this->postRoutes[$url_actual] ?? null;
        }

		// Eb caso de encontrarlo, lo ejecuta si no nos avisa de que no es valido
		// callback es la funcion que viene desde el index y this, el controlador que le pasamos
		// $router->get('/login', [AuthController::class, 'login']);
        if ( $callback ) {
            call_user_func($callback, $this);
        } else {
            echo "Página no encontrada o ruta no válida";
        }
    }


	// Recibe la vista y todos los datos que necesitemos pasarle
	public function renderizar($view, $datos = [])
    {
        foreach ($datos as $key => $value) {
            $$key = $value; 
        }

		// Guarda todo lo que se va a renderizar en un buffer temporal y lo almacena para enviar despues al navegador
        ob_start(); 

        include_once __DIR__ . "/views/$view.php";

		//Obtiene todo lo capturado y limpia el buffer. 
		//El contenido capturado se guarda en una variable y permite que todo quede en el orden que deseamos.
		// Permite construit primero la vista y luego insertarla en orden
        $contenido = ob_get_clean(); 

		// Si no hay info (estas en la raiz, añade /)
		$url_actual = $_SERVER['PATH_INFO'] ?? '/';
		//debuguear($url_actual);

		// Si la URL contiene admin, pasamos al layout de administradores
		if(str_contains($url_actual, '/admin')) {
			include_once __DIR__ . '/views/admin_layout.php';
		} else {
			include_once __DIR__ . '/views/layout.php';
		}

    }
}
