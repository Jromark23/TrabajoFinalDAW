<?php
//ORM
namespace Model;

/**
 * Clase base ActiveRecord.
 * Crea métodos para que los usen los modelos en la base de datos.
 *
 * @property Categoria $categoria
 * @property Categoria $categoria_id
 * @property Ponente $ponente
 * @property Ponente $ponente_id
 * @property Dia $dia
 * @property Dia $dia_id
 * @property Hora $hora
 * @property Hora $hora_id
 */
abstract class ActiveRecord
{

	// BBDD
	protected static \PDO $db;
	protected static $tabla = '';
	protected static $columnasDB = [];
	protected static $alertas = [];

	/**
	 * Crea la conexion a la BBDD.
	 *
	 * @param \PDO $database
	 * @return void
	 */
	public static function setDB(\PDO $database): void
	{
		self::$db = $database;
	}

	/**
	 * Registra una alerta en las validaciones.
	 *
	 * @param string $tipo Tipo de alerta
	 * @param string $mensaje
	 * @return void
	 */
	public static function setAlerta($tipo, $mensaje)
	{
		static::$alertas[$tipo][] = $mensaje;
	}

	/**
	 * Devuelve todas las alertas.
	 *
	 * @return array
	 */
	public static function getAlertas()
	{
		return static::$alertas;
	}

	/**
	 * Método de validación. Limpia y devuelve las alertas del modelo
	 *
	 * @return array
	 */
	public function validar()
	{
		static::$alertas = [];
		return static::$alertas;
	}

	/**
	 * Ejecuta una consulta SQL y devuelve los resultados como objetos del modelo.
	 *
	 * @param string $query Consulta personalizada
	 * @param array $params Parametros para la consulta
	 * @return array Devuelve un array de objetos en base a la BBDD
	 */
	public static function consultarSQL($query, $params = [])
	{
		$stmt = self::$db->prepare($query);
		$stmt->execute($params);

		$array = [];
		while ($registro = $stmt->fetch(\PDO::FETCH_ASSOC)) {
			$array[] = static::crearObjeto($registro);
		}
		return $array;
	}

	/**
	 * Crea un objeto del modelo a partir de un array de datos.
	 *
	 * @param array $registro
	 * @return static
	 */
	protected static function crearObjeto($registro)
	{
		$objeto = new static;

		foreach ($registro as $key => $value) {
			// Si la clase del objeto tiene la propiedad dada, asigna el valor a esa propiedad
			if (property_exists($objeto, $key)) {
				$objeto->$key = $value;
			}
		}
		return $objeto;
	}

	/** 
	 * Actualiza el objeto con los valores del array que le das.
	 *
	 * @param array $args
	 * @return void
	 */
	public function sincronizar($args = [])
	{
		foreach ($args as $key => $value) {
			// Si la propiedad existe en la clase el objeto, y el valor no es nulo, lo asigna
			if (property_exists($this, $key) && !is_null($value)) {
				$this->$key = $value;
			}
		}
	}

	/**
	 * Crea o actualiza un registro en la base de datos.
	 *
	 * @return mixed
	 */
	public function guardar()
	{
		if (!is_null($this->id)) {
			return $this->actualizar();
		} else {
			return $this->crearUsuario();
		}
	}

	/**
	 * Obtiene todos los registros de la tabla ordenados ASC o DESC.
	 *
	 * @param string $orden ASC o DESC
	 * @return array
	 */
	public static function all($orden = 'DESC')
	{
		$orden = strtoupper($orden) === 'ASC' ? 'ASC' : 'DESC';
		$query = "SELECT * FROM " . static::$tabla . " ORDER BY id $orden";
		return self::consultarSQL($query);
	}

	/**
	 * Obtiene registros seleccionando las columnas a extraer.
	 *
	 * @param array $array Columnas que quieres extraer
	 * @return array
	 */
	public static function allArray($array = [])
	{
		// Crea un nuevo array con los elementos entre ' '
		$cols = array_map(function ($col) {
			return "`$col`";
		}, $array);
		// Separa cada elemento de las columnas por ","
		$query = "SELECT " . join(', ', $cols) . " FROM " . static::$tabla . " ORDER BY id DESC";
		return self::consultarSQL($query);
	}

	/**
	 * Busca un registro por ID.
	 *
	 * @param int $id
	 * @return static|null
	 */
	public static function find(int $id)
	{
		$query = "SELECT * FROM " . static::$tabla . " WHERE id = :id LIMIT 1";
		$stmt = self::$db->prepare($query);
		$stmt->bindValue(':id', $id, \PDO::PARAM_INT);
		$stmt->execute();
		$registro = $stmt->fetch(\PDO::FETCH_ASSOC);
		return $registro ? static::crearObjeto($registro) : null;
	}

	/**
	 * Busca los N registros que indiquemos en el límite.
	 *
	 * @param int $limite de registros a obtener
	 * @return array
	 */
	public static function get($limite)
	{
		$query = "SELECT * FROM " . static::$tabla . " ORDER BY id DESC LIMIT :limite";
		$stmt = self::$db->prepare($query);
		$stmt->bindValue(':limite', (int)$limite, \PDO::PARAM_INT);
		$stmt->execute();
		$array = [];
		while ($registro = $stmt->fetch(\PDO::FETCH_ASSOC)) {
			$array[] = static::crearObjeto($registro);
		}
		return $array;
	}

	/**
	 * Busca un registro por columna y valor.
	 *
	 * @param string $columna
	 * @param mixed $valor
	 * @return static|null
	 */
	public static function where($columna, $valor)
	{
		if (!in_array($columna, static::$columnasDB)) {
			throw new \Exception('Columna no válida');
		}
		$query = "SELECT * FROM " . static::$tabla . " WHERE $columna = :valor LIMIT 1";
		$stmt = self::$db->prepare($query);
		$stmt->bindValue(':valor', $valor);
		$stmt->execute();
		$registro = $stmt->fetch(\PDO::FETCH_ASSOC);
		return $registro ? static::crearObjeto($registro) : null;
	}

	/**
	 * Busca registros ordenados por columna ASC o DESC.
	 *
	 * @param string $columna
	 * @param string $orden
	 * @return array
	 */
	public static function whereOrden($columna, $orden)
	{
		if (!in_array($columna, static::$columnasDB)) {
			throw new \Exception('Columna no válida');
		}
		$orden = strtoupper($orden) === 'ASC' ? 'ASC' : 'DESC';
		$query = "SELECT * FROM " . static::$tabla . " ORDER BY $columna $orden";
		return self::consultarSQL($query);
	}

	/**
	 * Busca registros ordenados por una columna ASC o DESC y con limite.
	 *
	 * @param string $columna
	 * @param string $orden
	 * @param int $limit
	 * @return array
	 */
	public static function whereOrdenLimit($columna, $orden, $limit)
	{
		if (!in_array($columna, static::$columnasDB)) {
			throw new \Exception('Columna no válida');
		}
		$orden = strtoupper($orden) === 'ASC' ? 'ASC' : 'DESC';
		$query = "SELECT * FROM " . static::$tabla . " ORDER BY $columna $orden LIMIT :limite";
		$stmt = self::$db->prepare($query);
		$stmt->bindValue(':limite', (int)$limit, \PDO::PARAM_INT);
		$stmt->execute();
		$array = [];
		while ($registro = $stmt->fetch(\PDO::FETCH_ASSOC)) {
			$array[] = static::crearObjeto($registro);
		}
		return $array;
	}

	/**
	 * Busca registros usando un array de condiciones.
	 *
	 * @param array $array
	 * @return array
	 */
	public static function whereArray($array = [])
	{
		$where = [];	// Elementos del where
		$params = [];	// Los elementos que necesitan BIND
		foreach ($array as $clave => $valor) {
			// Si la clave no existe en las columbas del objeto, lanzamos error.
			if (!in_array($clave, static::$columnasDB)) {
				throw new \Exception('Columna no válida');
			}
			$where[] = "$clave = :$clave";
			$params[":$clave"] = $valor;
		}
		$query = "SELECT * FROM " . static::$tabla;
		// si existe un where, se añaden los que haya a la consulta
		if ($where) {
			$query .= " WHERE " . join(' AND ', $where);
		}
		return self::consultarSQL($query, $params);
	}

	/**
	 * Devuelve todos los atributos del objeto excepto el ID.
	 *
	 * @return array
	 */
	public function atributos()
	{
		$atributos = [];
		foreach (static::$columnasDB as $columna) {
			if ($columna === 'id') continue;
			$atributos[$columna] = $this->$columna;
		}
		return $atributos;
	}

	/**
	 * Crea un nuevo registro en la base de datos.
	 *
	 * @return array
	 */
	public function crearUsuario()
	{
		// Atributos sin ID
		$atributos = $this->atributos();
		// Crea un array solo con las claves (columnas)
		$columns = array_keys($atributos);
		// Crea un array en el que cada elemento col pasa a ser :col para bind
		$placeholders = array_map(function ($col) {
			return ":$col";
		}, $columns);

		$sql  = "INSERT INTO " . static::$tabla . " (" . join(', ', $columns) . ") VALUES (" . join(', ', $placeholders) . ")";
		$stmt = self::$db->prepare($sql);

		foreach ($atributos as $key => $value) {
			$stmt->bindValue(":$key", $value);
		}

		$ok = $stmt->execute();
		return [
			'resultado' => $ok,
			'id'        => $ok ? self::$db->lastInsertId() : null
		];
	}

	/**
	 * Actualiza el registro en la base de datos.
	 *
	 * @return bool
	 */
	public function actualizar()
	{
		// Atributos sin ID 
		$atributos = $this->atributos();
		$valores = [];
		foreach ($atributos as $key => $value) {
			$valores[] = "$key = :$key";
		}
		$query = "UPDATE " . static::$tabla . " SET " . join(', ', $valores) . " WHERE id = :id LIMIT 1";
		$stmt = self::$db->prepare($query);

		foreach ($atributos as $key => $value) {
			$stmt->bindValue(":$key", $value);
		}
		$stmt->bindValue(':id', $this->id, \PDO::PARAM_INT);

		return $stmt->execute();
	}

	/**
	 * Elimina el registro de la base de datos.
	 *
	 * @return bool
	 */
	public function eliminar()
	{
		$query = "DELETE FROM "  . static::$tabla . " WHERE id = :id";
		$stmt = self::$db->prepare($query);
		$stmt->bindValue(':id', $this->id, \PDO::PARAM_INT);
		return $stmt->execute();
	}

	/**
	 * Cuenta el total de registros, puedes filtrar por columna dando columna y valor.
	 *
	 * @param string $columna
	 * @param mixed $valor
	 * @return int
	 */
	public static function count($columna = '', $valor = '')
	{
		$query = "SELECT COUNT(*) as total FROM " . static::$tabla;
		$params = [];
		if ($columna) {
			if (!in_array($columna, static::$columnasDB)) {
				throw new \Exception('Columna no válida');
			}
			$query .= " WHERE $columna = :valor";
			$params[':valor'] = $valor;
		}
		$stmt = self::$db->prepare($query);
		$stmt->execute($params);
		$fila = $stmt->fetch(\PDO::FETCH_ASSOC);
		return $fila['total'] ?? 0;
	}

	/**
	 * Cuenta el total de registros usando un array de condiciones.
	 *
	 * @param array $array
	 * @return int
	 */
	public static function totalArray($array = [])
	{
		$where = [];	// Elementos del where
		$params = [];	// Los elementos que necesitan BIND
		foreach ($array as $clave => $valor) {
			// Si la clave no existe en las columbas del objeto, lanzamos error.
			if (!in_array($clave, static::$columnasDB)) {
				throw new \Exception('Columna no válida');
			}
			$where[] = "$clave = :$clave";
			$params[":$clave"] = $valor;
		}
		$query = "SELECT COUNT(*) as total FROM " . static::$tabla;
		// si existe un where, se añaden los que haya a la consulta
		if ($where) {
			$query .= " WHERE " . join(' AND ', $where);
		}
		$stmt = self::$db->prepare($query);
		$stmt->execute($params);
		$fila = $stmt->fetch(\PDO::FETCH_ASSOC);
		return $fila['total'] ?? 0;
	}

	/**
	 * Obtiene registros paginados.
	 *
	 * @param int $numero LIMITE
	 * @param int $offset DESDE DONDE
	 * @return array
	 */
	public static function paginar($numero, $offset)
	{
		$query = "SELECT * FROM " . static::$tabla . " ORDER BY 1 DESC LIMIT :numero OFFSET :offset";
		$stmt = self::$db->prepare($query);
		$stmt->bindValue(':numero', (int)$numero, \PDO::PARAM_INT);
		$stmt->bindValue(':offset', (int)$offset, \PDO::PARAM_INT);
		$stmt->execute();
		$array = [];
		while ($registro = $stmt->fetch(\PDO::FETCH_ASSOC)) {
			$array[] = static::crearObjeto($registro);
		}
		return $array;
	}
}
