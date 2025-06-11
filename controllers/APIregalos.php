<?php

namespace Controllers;

use Model\Regalo;
use Model\Registro;

/**
 * API para obtener los regalos elegidos por los usuarios.
 */
class APIregalos
{
    /**
     * Devuelve un listado de regalos y la cantidad elegida por los usuarios para 
	 * poder prepararlos con tiempo.
     *
     * @return void
     */
	public static function index()
	{

		if(!is_admin()) {
			echo json_encode([]);
		return;	
		}
		$regalos = Regalo::all();

		foreach($regalos as $regalo) {
			$regalo->total = Registro::totalArray(['regalo_id' => $regalo->id, 
															'paquete_id' => "1"]);
		}

		echo json_encode($regalos);
		return;
	}
}
