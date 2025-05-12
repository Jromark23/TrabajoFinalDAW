<?php 

namespace Controllers;
use Model\Ponente;

class APIponentes {
	// Api para traer los ponentes a los eventos
	public static function index() {
		
		$ponentes = Ponente::allArray(["id","nombre","apellido"] );
		echo json_encode($ponentes);
	}
}