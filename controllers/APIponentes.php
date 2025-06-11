<?php 

namespace Controllers;
use Model\Ponente;

/**
 * API para obtener información de los ponentes.
 */
class APIponentes {
    /**
     * Devuelve una lista de ponentes para los eventos.
     *
     * @return void
     */
	public static function index() {
		
		$ponentes = Ponente::allArray(["id","nombre","apellido","ciudad","pais"] );
		echo json_encode($ponentes);
	}

    /**
     * Devuelve la información de un ponente por ID.
     *
     * @return void
     */
	public static function ponente() { 

		$id = $_GET['id'];
		$id = filter_var($id, FILTER_VALIDATE_INT);

		if(!$id || $id < 1) {
			echo json_encode([]);
			return;
		}

		$ponente = Ponente::find($id);
		echo json_encode($ponente, JSON_UNESCAPED_SLASHES);
	}

}