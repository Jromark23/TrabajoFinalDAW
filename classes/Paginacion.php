<?php 

namespace Classes;

class Paginacion {
	public $pagina_actual;
	public $registros_pagina;
	public $total_registros;

	public function __construct($pagina_actual = 1, $registros_pagina = 10, $total_registros = 0) {
		
		$this->pagina_actual = (int)$pagina_actual;
		$this->registros_pagina = (int)$registros_pagina;
		$this->total_registros = (int)$total_registros;
	}

	// Calcula el offset de la consulta. Comienzan en 0
	public function offset() {
		return $this->registros_pagina * ($this->pagina_actual - 1);
	}

	// Calcula el total de páginas necesarias, redondeando al alza
	public function total_paginas() {
		if ($this->registros_pagina <= 0) {
			return 0; 
		}
		return ceil($this->total_registros / $this->registros_pagina);
	}

	public function pagina_anterior() {	
		$anterior = $this->pagina_actual - 1;
		return ($anterior > 0) ? $anterior : false;
	}

	public function pagina_siguiente() {
		$siguiente = $this->pagina_actual + 1;
		return ($siguiente <=  $this->total_paginas()) ? $siguiente : false;
	}

	// Genera enlace anterior solo si es posible seguir volviendo
	public function enlace_anterior() {
		$html = '';

		if($this->pagina_anterior()) {
			$html.= "<a class=\"paginacion__enlace paginacion__enlace--texto\" href=\"?page={$this->pagina_anterior()}\">
				&laquo; Anterior</a>";
		}

		return $html;
	}

	// Genera enlace siguiente solo si es posible seguir avanzando
	public function enlace_siguiente() {
		$html = '';

		if($this->pagina_siguiente()) {
			$html.= "<a class=\"paginacion__enlace paginacion__enlace--texto\" href=\"?page={$this->pagina_siguiente()}\">
				Siguiente &raquo;</a>";
		}

		return $html;
	}

	public function numeros_paginas() {
		$html = '';
		$actual = $this->pagina_actual;
		$total = $this->total_paginas();

		for($i = $actual - 2; $i <= $actual + 2; $i++) {
			if ($i < 1 || $i > $total) {
				continue; 
			}
			if($i === $this->pagina_actual) {
				$html.= "<span class=\"paginacion__enlace paginacion__enlace--actual\">{$i}</span>";
			} else {
				$html .= "<a class=\"paginacion__enlace paginacion__enlace--numero\" href=\"?page={$i}\">{$i}</a>";
			}
		}

		return $html;
	}

	public function paginacion() {
		$html = '';

		if($this->total_registros > 1) {
			$html.= "<div class=\"paginacion\">";
			$html.= $this->enlace_anterior();  
			$html.= $this->numeros_paginas();  
			$html.= $this->enlace_siguiente();
			$html.= "</div>";

		}

		return $html;
	}

}