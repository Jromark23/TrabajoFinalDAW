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

abstract class ActiveRecord {

    // Base DE DATOS
    protected static \PDO $db;
    protected static $tabla = '';
    protected static $columnasDB = [];

    // Alertas y Mensajes
    protected static $alertas = [];

    // Definir la conexión a la BD - includes/database.php
    public static function setDB(\PDO $database): void {
        self::$db = $database;
    }

    // Setear un tipo de Alerta
    public static function setAlerta($tipo, $mensaje)
    {
        static::$alertas[$tipo][] = $mensaje;
    }

    // Obtener las alertas
    public static function getAlertas() {
        return static::$alertas;
    }

    // Validación que se hereda en modelos
    public function validar() {
        static::$alertas = [];
        return static::$alertas;
    }

    // Consulta SQL para crear un objeto en Memoria (Active Record)
    public static function consultarSQL($query, $params = []) {
        $stmt = self::$db->prepare($query);
        $stmt->execute($params);

        $array = [];
        while ($registro = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $array[] = static::crearObjeto($registro);
        }
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

    // Identificar y unir los atributos de la BD (excepto el ID)
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
        // Con PDO, la sanitización se maneja con parámetros preparados
        return $this->atributos();
    }

    /** 
     * Actualiza el objeto con los valores del array que le das.
     */
    public function sincronizar($args = [])
    {
        foreach ($args as $key => $value) {
            if (property_exists($this, $key) && !is_null($value)) {
                $this->$key = $value;
            }
        }
    }

    // Si tiene ID, actualizamos y si no, creamos. 
    public function guardar()
    {
        if (!is_null($this->id)) {
            return $this->actualizar();
        } else {
            return $this->crear();
        }
    }

    // Obtener todos los Registros
    public static function all($orden = 'DESC')
    {
        $orden = strtoupper($orden) === 'ASC' ? 'ASC' : 'DESC';
        $query = "SELECT * FROM " . static::$tabla . " ORDER BY id $orden";
        return self::consultarSQL($query);
    }

    public static function allArray($array = [])
    {
        $cols = array_map(function($col) {
            return "`$col`";
        }, $array);
        $query = "SELECT " . implode(', ', $cols) . " FROM " . static::$tabla;
        return self::consultarSQL($query);
    }

    // Busca un registro por su id
    public static function find(int $id)
    {
        $query = "SELECT * FROM " . static::$tabla . " WHERE id = :id LIMIT 1";
        $stmt = self::$db->prepare($query);
        $stmt->bindValue(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();
        $registro = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $registro ? static::crearObjeto($registro) : null;
    }

    // Obtener Registros con cierta cantidad
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

    // Busqueda Where con columna y valor 
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

    // Busqueda Where con un orden
    public static function whereOrden($columna, $orden)
    {
        if (!in_array($columna, static::$columnasDB)) {
            throw new \Exception('Columna no válida');
        }
        $orden = strtoupper($orden) === 'ASC' ? 'ASC' : 'DESC';
        $query = "SELECT * FROM " . static::$tabla . " ORDER BY $columna $orden";
        return self::consultarSQL($query);
    }

    // Busqueda Where con un orden y un limite
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

    // Busqueda where con varias opciones mediante array
    public static function whereArray($array = [])
    {
        $where = [];
        $params = [];
        foreach ($array as $clave => $valor) {
            if (!in_array($clave, static::$columnasDB)) {
                throw new \Exception('Columna no válida');
            }
            $where[] = "$clave = :$clave";
            $params[":$clave"] = $valor;
        }
        $query = "SELECT * FROM " . static::$tabla;
        if ($where) {
            $query .= " WHERE " . implode(' AND ', $where);
        }
        return self::consultarSQL($query, $params);
    }

    // crea un nuevo usuario
    public function crear()
    {
        $atributos = $this->sanitizarAtributos();
        $columns = array_keys($atributos);
        $placeholders = array_map(function($col) { return ":$col"; }, $columns);

        $sql  = "INSERT INTO " . static::$tabla . " (" . implode(', ', $columns) . ") VALUES (" . implode(', ', $placeholders) . ")";
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

    // Actualizar el registro
    public function actualizar()
    {
        $atributos = $this->sanitizarAtributos();
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

    // Eliminar registro por ID 
    public function eliminar()
    {
        $query = "DELETE FROM "  . static::$tabla . " WHERE id = :id";
        $stmt = self::$db->prepare($query);
        $stmt->bindValue(':id', $this->id, \PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Total registros con posibilidad de filtrar
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

    // Total registros con array where 
    public static function totalArray($array = [])
    {
        $where = [];
        $params = [];
        foreach ($array as $clave => $valor) {
            if (!in_array($clave, static::$columnasDB)) {
                throw new \Exception('Columna no válida');
            }
            $where[] = "$clave = :$clave";
            $params[":$clave"] = $valor;
        }
        $query = "SELECT COUNT(*) as total FROM " . static::$tabla;
        if ($where) {
            $query .= " WHERE " . implode(' AND ', $where);
        }
        $stmt = self::$db->prepare($query);
        $stmt->execute($params);
        $fila = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $fila['total'] ?? 0;
    }

    // Paginar registros, numero de registros y desde donde
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
