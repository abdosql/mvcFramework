<?php
//Using the namespace

use app\Controllers\AuthController;
use app\core\Application;
use app\Controllers\siteController;
//requiring the autoloader
require_once __DIR__ . '/vendor/autoload.php';
$dotenv = \Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
$config = [
    'db' => [
        "dsn" => $_ENV["DB_DSN"],
        "user" => $_ENV["DB_USER"],
        "password" => $_ENV["DB_PASSWORD"]
    ]
];
$app = new Application(__DIR__, $config);
$app->db->applyMigrations();
