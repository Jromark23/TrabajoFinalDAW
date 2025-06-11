<?php 

use Dotenv\Dotenv;
use Model\ActiveRecord;

/**
 * Carga automática de clases y configuración de entorno.
 * 
 * Inicializas variables de entorno y carga funciones auxiliares,
 * Conecta la base de datos y configura ActiveRecord.
 */

require __DIR__ . '/../vendor/autoload.php';

// Carga de manera segura las variables de .env que están en la misma carpeta
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

// Traemos las funciones auxiliares del proyecto y la base de datos
require __DIR__ . '/funciones.php';
require __DIR__ . '/database.php';

// Conectamos ActiveRecord a la base de datos
ActiveRecord::setDB($db);