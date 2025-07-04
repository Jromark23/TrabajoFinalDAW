<?php 

namespace Controllers;

use Model\HorarioEvento; 

/**
 * API para obtener eventos según día y categoría.
 */
class APIeventos {
    /**
     * Devuelve los eventos filtrados por día y categoría.
     *
     * @return void
     */
	public static function index() {
		$dia_id = $_GET['dia_id'] ?? '';
		$categoria_id = $_GET['categoria_id'] ?? '';

		$dia_id = filter_var($dia_id, FILTER_VALIDATE_INT);
		$categoria_id = filter_var($categoria_id, FILTER_VALIDATE_INT);

		// Si dia o categoria no son correctos devolvemos vacio
		if(!$dia_id || !$categoria_id) {
			echo json_encode([]);
			return;
		}

		// Consultar BBDD
		$eventos = HorarioEvento::whereArray(['dia_id' => $dia_id, 'categoria_id' => $categoria_id]) ?? [];

		echo json_encode($eventos);
	}
}