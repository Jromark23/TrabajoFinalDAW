<?php
//ORM
namespace Model;

/**
 * Creadas en tiempo de ejecucion, poniendolas aqui no muestra error. 
 * @property Categoria $categoria
 * @property Categoria $categoria_id
 * @property Ponente $ponente
 * @property Ponente $ponente_id
 * @property Dia $dia
 * @property Dia $dia_id
 * @property Hora $hora
 * @property Hora $hora_id
 */
class ActiveRecord
{
	// Base DE DATOS
	protected static $db;
	protected static $tabla = '';
	protected static $columnasDB = [];

	// Alertas y Mensajes
	protected static $alertas = [];

	// Definir la conexión a la BD - includes/database.php
	public static function setDB($database)
	{
		self::$db = $database;
	}

	// Setear un tipo de Alerta
	public static function setAlerta($tipo, $mensaje)
	{
		static::$alertas[$tipo][] = $mensaje;
	}

	// Obtener las alertas
	public static function getAlertas()
	{
		return static::$alertas;
	}

	// Validación que se hereda en modelos
	public function validar()
	{
		static::$alertas = [];
		return static::$alertas;
	}

	// Consulta SQL para crear un objeto en Memoria (Active Record)
	public static function consultarSQL($query)
	{
		// Consultar la base de datos
		$resultado = self::$db->query($query);

		// Iterar los resultados
		$array = [];
		while ($registro = $resultado->fetch_assoc()) {
			$array[] = static::crearObjeto($registro);
		}

		// liberar la memoria
		$resultado->free();

		// retornar los resultados
		return $array;
	}

	// Crea el objeto en memoria que es igual al de la BD
	protected static function crearObjeto($registro)
	{
		$objeto = new static;

		foreach ($registro as $key => $value) {
			if (property_exists($objeto, $key)) {
				$objeto->$key = $value;
			}
		}
		return $objeto;
	}

	// Identificar y unir los atributos de la BD
	public function atributos()
	{
		$atributos = [];
		foreach (static::$columnasDB as $columna) {
			if ($columna === 'id') continue;
			$atributos[$columna] = $this->$columna;
		}
		return $atributos;
	}

	// Sanitizar los datos antes de guardarlos en la BD
	public function sanitizarAtributos()
	{
		$atributos = $this->atributos();
		$sanitizado = [];
		foreach ($atributos as $key => $value) {
			$sanitizado[$key] = self::$db->escape_string($value);
		}
		return $sanitizado;
	}

	/** 
	 * Actualiza el objeto con los valores del array que le das.
	 *	Recorre el array, y si existe y no es nulo lo asigna a cada propiedad
	 *	asi puedes recibir $_POST y directamente asignar datos.
	 */
	public function sincronizar($args = [])
	{

		foreach ($args as $key => $value) {
			if (property_exists($this, $key) && !is_null($value)) {
				$this->$key = $value;
			}
		}
	}

	// Registros - CRUD
	public function guardar()
	{
		$resultado = '';
		if (!is_null($this->id)) {
			// actualizar
			$resultado = $this->actualizar();
		} else {
			// Creando un nuevo registro
			$resultado = $this->crear();
		}
		return $resultado;
	}

	// Obtener todos los Registros
	public static function all($orden = 'DESC')
	{
		$query = "SELECT * FROM " . static::$tabla . " ORDER BY id $orden";
		$resultado = self::consultarSQL($query);
		return $resultado;
	}

	public static function allArray($array = [])
	{
		$query = "SELECT ";

		// Convertimos el array en una lista separada por comas
		$query .= implode(', ', $array);

		$query .= " FROM " . static::$tabla;

		$resultado = self::consultarSQL($query);
		return $resultado;
	}


	// Busca un registro por su id
	public static function find($id)
	{
		$query = "SELECT * FROM " . static::$tabla  . " WHERE id = $id";
		$resultado = self::consultarSQL($query);
		return array_shift($resultado);
	}

	// Obtener Registros con cierta cantidad
	public static function get($limite)
	{
		$query = "SELECT * FROM " . static::$tabla . " ORDER BY id DESC LIMIT $limite";
		$resultado = self::consultarSQL($query);
		return $resultado;
	}

	// Busqueda Where con columna y valor 
	public static function where($columna, $valor)
	{
		$query = "SELECT * FROM " . static::$tabla . " WHERE $columna = '$valor'";
		$resultado = self::consultarSQL($query);
		return array_shift($resultado);
	}

	// Busqueda Where con un orden
	public static function whereOrden($columna, $orden)
	{
		$query = "SELECT * FROM " . static::$tabla . " ORDER BY $columna $orden";
		$resultado = self::consultarSQL($query);
		return $resultado;
	}

	// Busqueda Where con un orden y un limite
	public static function whereOrdenLimit($columna, $orden, $limit)
	{
		$query = "SELECT * FROM " . static::$tabla . " ORDER BY $columna $orden LIMIT $limit";
		$resultado = self::consultarSQL($query);
		return $resultado;
	}
	// Busqueda where con varias opciones mediante array
	public static function whereArray($array = [])
	{
		$query = "SELECT * FROM " . static::$tabla . " WHERE ";

		foreach ($array as $clave => $valor) {
			//Detecta el ultimo elemento del array
			if ($clave == array_key_last($array)) {
				$query .= " $clave = '$valor'";
			} else {
				$query .= " $clave = '$valor' AND ";
			}
		}

		//echo $query;

		$resultado = self::consultarSQL($query);
		return $resultado;
	}

	// crea un nuevo registro
	public function crear()
	{
		// Sanitizar los datos
		$atributos = $this->sanitizarAtributos();

		// Insertar en la base de datos
		$query = " INSERT INTO " . static::$tabla . " ( ";
		$query .= join(', ', array_keys($atributos));
		$query .= " ) VALUES (' ";
		$query .= join("', '", array_values($atributos));
		$query .= " ') ";

		// debuguear($query); // Descomentar si no te funciona algo

		// Resultado de la consulta
		$resultado = self::$db->query($query);
		return [
			'resultado' =>  $resultado,
			'id' => self::$db->insert_id
		];
	}

	// Actualizar el registro
	public function actualizar()
	{
		// Sanitizar los datos
		$atributos = $this->sanitizarAtributos();

		// Iterar para ir agregando cada campo de la BD
		$valores = [];
		foreach ($atributos as $key => $value) {
			$valores[] = "{$key}='{$value}'";
		}

		// Consulta SQL
		$query = "UPDATE " . static::$tabla . " SET ";
		$query .=  join(', ', $valores);
		$query .= " WHERE id = '" . self::$db->escape_string($this->id) . "' ";
		$query .= " LIMIT 1 ";

		// Actualizar BD
		$resultado = self::$db->query($query);
		return $resultado;
	}

	// Eliminar regustro por ID 
	public function eliminar()
	{
		$query = "DELETE FROM "  . static::$tabla . " WHERE id = " . self::$db->escape_string($this->id);
		$resultado = self::$db->query($query);
		return $resultado;
	}

	// Total registros con posibilidad de filtrar
	public static function count($columna = '', $valor = '')
	{
		$query = "SELECT COUNT(*) as total FROM " . static::$tabla;

		if ($columna) {
			$query .= " WHERE $columna = $valor";
		}
		$resultado = self::$db->query($query);
		$fila = $resultado->fetch_assoc();
		return $fila['total'] ?? 0;
	}

	// Total registros con array where 
	public static function totalArray($array = [])
	{
		$query = "SELECT COUNT(*) FROM " . static::$tabla . " WHERE ";

		foreach ($array as $clave => $valor) {
			//Detecta el ultimo elemento del array
			if ($clave == array_key_last($array)) {
				$query .= " $clave = '$valor'";
			} else {
				$query .= " $clave = '$valor' AND ";
			}
		}

		$resultado = self::$db->query($query);
		$total = $resultado->fetch_array();
		return array_shift($total);
	}

	// Paginar registros, numero de registros y desde donde
	public static function paginar($numero, $offset)
	{
		$query = "SELECT * FROM " . static::$tabla . " ORDER BY 1 DESC LIMIT $numero OFFSET $offset ";
		$resultado = self::consultarSQL($query);
		return $resultado;
	}
}
