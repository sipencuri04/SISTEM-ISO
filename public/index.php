<?php
session_start();


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

define('BASE_PATH', dirname(__DIR__));
define('BASE_URL', '/SISTEM-ISO/public/');
define('BASE_URL_INDEX', '/SISTEM-ISO/public/index.php');

/* 🔴 WAJIB LOAD DATABASE DI SINI */
require_once BASE_PATH . '/app/config/database.php';

/* 🔧 LOAD HELPER FUNCTIONS */
require_once BASE_PATH . '/app/config/helpers.php';

/* ROUTER */
$controllerName = $_GET['controller'] ?? 'Auth';
$action         = $_GET['action'] ?? 'login';

$controllerName = preg_replace('/[^a-zA-Z]/', '', $controllerName);
$action         = preg_replace('/[^a-zA-Z]/', '', $action);

$controllerFile = BASE_PATH . '/app/controllers/' . $controllerName . '.php';
if (!file_exists($controllerFile)) {
    die("Controller {$controllerName} tidak ditemukan");
}

require_once $controllerFile;

$controller = new $controllerName();

if (!method_exists($controller, $action)) {
    die("Method {$action} tidak ditemukan");
}

$controller->$action();
