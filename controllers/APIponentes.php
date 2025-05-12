<?php 

namespace Controllers;
use Model\Ponente;

class APIponentes {
	// Api para traer los ponentes a los eventos
	public static function index() {
		
		$ponentes = Ponente::allArray(["id","nombre","apellido"] );
		echo json_encode($ponentes);
	}

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