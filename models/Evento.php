<?php

namespace Model;

/**
 * Modelo para la entidad Evento.
 */
class Evento extends ActiveRecord
{
	protected static $tabla = 'eventos';
	protected static $columnasDB = ['id', 'nombre', 'descripcion', 'disponibles', 'categoria_id', 'dia_id', 'hora_id', 'ponente_id'];

	public $id;
	public $nombre;
	public $descripcion;
	public $disponibles;
	public $categoria_id;
	public $dia_id;
	public $hora_id;
	public $ponente_id;

	/**
	 * Constructor del modelo Evento.
	 *
	 * @param array $args Datos iniciales del evento.
	 */
	public function __construct($args = [])
	{
		$this->id = $args['id'] ?? null;
		$this->nombre = $args['nombre'] ?? '';
		$this->descripcion = $args['descripcion'] ?? '';
		$this->disponibles = $args['disponibles'] ?? '';
		$this->categoria_id = $args['categoria_id'] ?? '';
		$this->dia_id = $args['dia_id'] ?? '';
		$this->hora_id = $args['hora_id'] ?? '';
		$this->ponente_id = $args['ponente_id'] ?? '';
	}

	/**
	 * Valida los datos para la creación de un evento.
	 *
	 * @return array Alertas de validación.
	 */
	public function validar()
	{
		if (!$this->nombre) {
			self::$alertas['error'][] = 'El nombre es obligatorio';
		}
		if (!$this->descripcion) {
			self::$alertas['error'][] = 'La descripción es obligatoria';
		}
		if (!$this->categoria_id  || !filter_var($this->categoria_id, FILTER_VALIDATE_INT)) {
			self::$alertas['error'][] = 'Elige una categoría';
		}
		if (!$this->dia_id  || !filter_var($this->dia_id, FILTER_VALIDATE_INT)) {
			self::$alertas['error'][] = 'Elige el día del evento';
		}
		if (!$this->hora_id  || !filter_var($this->hora_id, FILTER_VALIDATE_INT)) {
			self::$alertas['error'][] = 'Elige la hora del evento';
		}
		if (!$this->disponibles  || !filter_var($this->disponibles, FILTER_VALIDATE_INT)) {
			self::$alertas['error'][] = 'Añade el máximo de asientos disponibles';
		}
		if (!$this->ponente_id || !filter_var($this->ponente_id, FILTER_VALIDATE_INT)) {
			self::$alertas['error'][] = 'Selecciona el ponente';
		}

		return self::$alertas;
	}

	/**
	 * Carga las relaciones del evento (categoría, ponente, día, hora).
	 *
	 * @return void
	 */
	public function cargarRelaciones()
	{
		$this->categoria = Categoria::find($this->categoria_id);
		$this->ponente = Ponente::find($this->ponente_id);
		$this->dia = Dia::find($this->dia_id);
		$this->hora = Hora::find($this->hora_id);
	}
}
