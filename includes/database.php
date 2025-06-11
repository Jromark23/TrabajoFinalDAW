<?php
declare(strict_types=1);

$host     = $_ENV['DB_HOST'] ?? 'localhost';
$dbname   = $_ENV['DB_NAME'] ?? '';
$user     = $_ENV['DB_USER'] ?? '';
$password = $_ENV['DB_PASS'] ?? '';
$charset  = 'utf8mb4';

// Crea el DSN (Data Source Name) de conexión con MySQL
$dsn = "mysql:host={$host};dbname={$dbname};charset={$charset}";

try {
    $db = new PDO(
        $dsn,
        $user,
        $password,
        // Opciones de configuración del PDO 
        [
            // Lanza excepciones si hay errores
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            // Los resultados los devuelve como array asociativo [clave = columna => dato]
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            // Usa sentencias preparadas reales del servidor 
            PDO::ATTR_EMULATE_PREPARES   => false,
        ]
    );
} catch (PDOException $e) {
    error_log('Database connection error: ' . $e->getMessage());

    echo 'Error al conectar la base de datos.';
    exit;
}
