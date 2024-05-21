<?php

require '../vendor/autoload.php';
require_once '../database/database-config.php';


use Illuminate\Database\Capsule\Manager as Capsule;

$capsule = new Capsule;

// Configuração da conexão PDO
$db = new Database(DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME, DB_PASSWORD);
$pdoConnection = $db->getConnection();

// Configuração do Eloquent para usar a conexão PDO
$capsule->addConnection([
    'driver' => 'mysql',
    'host' => DB_HOST,
    'port' => DB_PORT,
    'database' => DB_DATABASE,
    'username' => DB_USERNAME,
    'password' => DB_PASSWORD,
    'charset' => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix' => '',
    'strict' => false,
    'engine' => null,
    'options' => [
        PDO::ATTR_CASE => PDO::CASE_NATURAL,
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_ORACLE_NULLS => PDO::NULL_NATURAL,
        PDO::ATTR_STRINGIFY_FETCHES => false,
        PDO::ATTR_EMULATE_PREPARES => false,
    ],
]);

$capsule->setAsGlobal();
$capsule->bootEloquent();