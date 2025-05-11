<?php

namespace Model;

class Ponente extends ActiveRecord
{
	protected static $tabla = 'ponentes';
	protected static $columnasDB = ['id', 'nombre', 'apellido', 'ciudad', 'pais', 'imagen', 'tags', 'rrss'];

	public $id;
	public $nombre;
	public $apellido;
	public $ciudad;
	public $pais;
	public $imagen;
	public $tags;
	public $rrss;
	public $img_actual;


	public function __construct($args = [])
	{
		$this->id = $args['id'] ?? null;
		$this->nombre = $args['nombre'] ?? '';
		$this->apellido = $args['apellido'] ?? '';
		$this->ciudad = $args['ciudad'] ?? '';
		$this->pais = $args['pais'] ?? '';
		$this->imagen = $args['imagen'] ?? '';
		$this->tags = $args['tags'] ?? '';
		$this->rrss = $args['rrss'] ?? '';
	}

	public function validar()
	{
		if (!$this->nombre) {
			self::$alertas['error'][] = 'El nombre es obligatorio';
		}
		if (!$this->apellido) {
			self::$alertas['error'][] = 'Los apellidos es obligatorio';
		}
		if (!$this->ciudad) {
			self::$alertas['error'][] = 'La ciudad es obligatoria';
		}
		if (!$this->pais) {
			self::$alertas['error'][] = 'El país es obligatorio';
		}
		if (!$this->imagen) {
			self::$alertas['error'][] = 'La imagen es obligatoria';
		}
		if (!$this->tags) {
			self::$alertas['error'][] = 'Los conocimientos son obligatorios';
		}

		return self::$alertas;
	}
}
