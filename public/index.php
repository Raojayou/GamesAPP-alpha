<?php
require_once '../vendor/autoload.php';

use Phroute\Phroute\RouteCollector;

// Punto de entrada a la aplicación
require_once '../config.php';
require_once '../connectdb.php';
require_once '../arrays.php';
require_once '../helpers.php';
require_once '../dbhelpers.php';

$baseDir = str_replace(
    basename($_SERVER['SCRIPT_NAME']),
    '',
    $_SERVER['SCRIPT_NAME']);

$baseUrl = "http://" . $_SERVER['HTTP_HOST'] . $baseDir;
define('BASE_URL', $baseUrl);

$route = $_GET['route'] ?? "/";

function render($fileName, $params = []){
    // Activa el buffer interno de PHP para que toda la salida que va al navegador
    // se guarde en dicho buffer interno.
    ob_start(); // Omite cualquier salida de la aplicación y la almacena internamente

    extract($params); // Extrae los datos del array asociativo $params y los convierte en variables

    require($fileName);

    return ob_get_clean(); // Se trae los datos del buffer interno y lo limpia
}

$router = new RouteCollector();

$router->controller('/', App\Controllers\HomeController::class);

$dispatcher = new Phroute\Phroute\Dispatcher($router->getData());

$method = $_REQUEST['_method'] ?? $_SERVER['REQUEST_METHOD'];

$response = $dispatcher->dispatch($method, $route);

// Print out the value returned from the dispatched function
echo $response;