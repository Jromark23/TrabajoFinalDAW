<?php 

use Dotenv\Dotenv;
use Model\ActiveRecord;
require __DIR__ . '/../vendor/autoload.php';

// Carga de manera segura las variables de .env
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

// traemos las funciones auxiliares del proyecto, y la base de datos
require 'funciones.php';
require 'database.php';

// Conectarnos a la base de datos
ActiveRecord::setDB($db);