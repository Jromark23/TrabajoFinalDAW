<?php

namespace Model;

/**
 * Modelo para la entidad Usuario.
 */
class Usuario extends ActiveRecord
{
	protected static $tabla = 'usuarios';
	protected static $columnasDB = [
		'id',
		'nombre',
		'apellido',
		'email',
		'password',
		'token',
		'token_expiracion',
		'confirmado',
		'admin',
		'intentos_fallidos',
		'ultimo_intento'
	];

	public $id;
	public $nombre;
	public $apellido;
	public $email;
	public $password;
	public $password2;
	public $confirmado;
	public $token;
	public $token_expiracion;
	public $admin;
	public $intentos_fallidos;
	public $ultimo_intento;

	public $password_actual;
	public $password_nuevo;

	/**
	 * Constructor del modelo Usuario.
	 *
	 * @param array $args Datos del usuario.
	 */
	public function __construct($args = [])
	{
		$this->id = $args['id'] ?? null;
		$this->nombre = $args['nombre'] ?? '';
		$this->apellido = $args['apellido'] ?? '';
		$this->email = $args['email'] ?? '';
		$this->password = $args['password'] ?? '';
		$this->password2 = $args['password2'] ?? '';
		$this->confirmado = $args['confirmado'] ?? 0;
		$this->token = $args['token'] ?? '';
		$this->token_expiracion = $args['token_expiracion'] ?? null;
		$this->admin = $args['admin'] ?? '';
		$this->intentos_fallidos = $args['intentos_fallidos'] ?? 0;
		$this->ultimo_intento    = $args['ultimo_intento']    ?? null;
	}

	/**
	 * Valida los datos para el login.
	 *
	 * @return array Alertas de validación.
	 */
	public function validarLogin()
	{
		if (!$this->email) {
			self::$alertas['error'][] = 'Rellene el email';
		}

		$this->validarEmail(); // Solo llama, no uses if

		if (!$this->password) {
			self::$alertas['error'][] = 'La contraseña no puede estar vacía';
		}
		return self::$alertas;
	}

	/**
	 * Valida los datos para crear una nueva cuenta.
	 *
	 * @return array Alertas de validación.
	 */
	// Validación para cuentas nuevas
	public function validar_cuenta()
	{

		if (!$this->nombre) {
			self::$alertas['error'][] = 'El nombre es obligatorio';
		} elseif (strlen($this->nombre) < 2 || !preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/u', $this->nombre)) {
			self::$alertas['error'][] = 'El nombre solo puede tener letras, y ser al menos 2';
		}

		if (!$this->apellido) {
			self::$alertas['error'][] = 'El apellido es obligatorio';
		} elseif (strlen($this->apellido) < 2 || !preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/u', $this->apellido)) {
			self::$alertas['error'][] = 'El apellido solo puede tener letras, y ser al menos 2';
		}

		if (!$this->email) {
			self::$alertas['error'][] = 'El email es obligatorio';
		}
		$this->validarEmail(); // Solo llama, no uses if

		if (!$this->password) {
			self::$alertas['error'][] = 'La contraseña no puede estar vacía';
		} elseif (!$this->validarPassword()) {
			self::$alertas['error'][] = 'La contraseña debe tener al menos 6 caracteres, una mayúscula, una minúscula, un número y un símbolo';
		}
		if ($this->password !== $this->password2) {
			self::$alertas['error'][] = 'Las contraseñas son diferentes';
		}
		return self::$alertas;
	}

	/**
	 * Valida el formato del email.
	 *
	 * @return array Alertas de validación.
	 */
	public function validarEmail()
	{
		if (empty($this->email)) {
			self::$alertas['error'][] = 'El email es obligatorio';
		} elseif (
			!filter_var($this->email, FILTER_VALIDATE_EMAIL)
		) {
			self::$alertas['error'][] = 'Email no válido. Debe tener un formato correcto (ejemplo: usuario@dominio.com)';
		}
		return self::$alertas; // Siempre devuelve un array
	}



	/**
	 * Valida la contraseña (6 caracteres, una mayúscula, una minúscula, un número y un símbolo).
	 *
	 * @return bool
	 */
	public function validarPassword()
	{
		if (empty($this->password)) {
			self::$alertas['error'][] = 'La contraseña no puede estar vacía';
			return false;
		}

		if (
			strlen($this->password) < 6 ||
			!preg_match('/[A-Z]/', $this->password) ||
			!preg_match('/[a-z]/', $this->password) ||
			!preg_match('/[0-9]/', $this->password) ||
			!preg_match('/[\W_]/', $this->password)
		) {
			self::$alertas['error'][] =
				'La contraseña debe tener al menos 6 caracteres, una mayúscula, una minúscula, un número y un símbolo';
			return false;
		}

		return true;
	}



	/**
	 * Valida el cambio de contraseña.
	 *
	 * @return array Alertas de validación.
	 */
	public function nuevo_password(): array
	{
		if (!$this->password_actual) {
			self::$alertas['error'][] = 'Contraseña actual no puede estar vacío';
		}
		if (!$this->password_nuevo) {
			self::$alertas['error'][] = 'Contraseña nueva no puede ir vacío';
		} elseif (!$this->validarPassword()) {
			self::$alertas['error'][] = 'La nueva contraseña debe tener al menos 6 caracteres, una mayúscula, una minúscula, un número y un símbolo';
		}
		return self::$alertas;
	}

	/**
	 * Comprueba si la contraseña actual coincide con la guardada.
	 *
	 * @return bool
	 */
	public function comprobar_password(): bool
	{
		return password_verify($this->password_actual, $this->password);
	}

	/**
	 * Hashea la contraseña.
	 *
	 * @return void
	 */
	public function hashPassword(): void
	{
		$this->password = password_hash($this->password, PASSWORD_BCRYPT);
	}

	/**
	 * Genera un token único para el usuario.
	 *
	 * @return void
	 */
	public function crearToken(): void
	{
		$this->token = uniqid();
	}
}
