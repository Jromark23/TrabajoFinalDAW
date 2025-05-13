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

    public function comprobarRutas()
    {
		// Recupera la URL y el METHOD
        $url_actual = $_SERVER['PATH_INFO'] ?? '/';
        $method = $_SERVER['REQUEST_METHOD'];

        if ($method === 'GET') {
            $callback = $this->getRoutes[$url_actual] ?? null;
        } else {
            $callback = $this->postRoutes[$url_actual] ?? null;
        }


        if ( $callback ) {
            call_user_func($callback, $this);
        } else {
            echo "Página no encontrada o ruta no válida";
        }
    }

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

		$url_actual = $_SERVER['PATH_INFO'] ?? '/';
		//debuguear($url_actual);

		if(str_contains($url_actual, '/admin')) {
			include_once __DIR__ . '/views/admin_layout.php';
		} else {
			include_once __DIR__ . '/views/layout.php';
		}

    }
}
