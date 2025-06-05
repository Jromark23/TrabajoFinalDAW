<?php

namespace Model;

class Registro extends ActiveRecord
{
	protected static $tabla = 'registros';
	protected static $columnasDB = ['id', 'paquete_id', 'pago_id', 'token', 'usuario_id','regalo_id','validado'];

	public $id;
	public $paquete_id;
	public $pago_id;
	public $token;
	public $usuario_id;
	public $regalo_id;
	public $validado;

	public function __construct($args = [])
	{
		$this->id = $args['id'] ?? null;
		$this->paquete_id = $args['paquete_id'] ?? '';
		$this->pago_id = $args['pago_id'] ?? '';
		$this->token = $args['token'] ?? '';
		$this->usuario_id = $args['usuario_id'] ?? '';
		$this->regalo_id = $args['regalo_id'] ?? 1;
		$this->validado = $args['validado'] ?? 0;
	}

}