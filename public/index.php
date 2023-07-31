<?php
//Using the namespace

use app\Controllers\AuthController;
use app\core\Application;
use app\Controllers\siteController;
//requiring the autoloader
require_once __DIR__ . '/../vendor/autoload.php';
$dotenv = \Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();
$config = [
    "userClass" => \app\Models\User::class,
    'db' => [
        "dsn" => $_ENV["DB_DSN"],
        "user" => $_ENV["DB_USER"],
        "password" => $_ENV["DB_PASSWORD"]
    ]
];
//Creating an instance of the app object

$app = new Application(dirname(__DIR__), $config);
$app->router->get("/",[siteController::class, "Home"]);
$app->router->get("/contact", [siteController::class, "contact"]);
//Login
$app->router->get("/Login", [AuthController::class, "Login"]);
$app->router->post("/Login", [AuthController::class, "Login"]);
//Register
$app->router->get("/Register", [AuthController::class, "Register"]);
$app->router->post("/Register", [AuthController::class, "Register"]);
$app->router->get("/Logout", [AuthController::class, "_logout"]);
$app->router->get("/Profile", [AuthController::class, "Profile"]);

$app->run();
