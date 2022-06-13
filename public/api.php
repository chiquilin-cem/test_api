<?php
require "../bootstrap.php";
use Src\controller\ProductoController;
use Src\controller\CategoriaController;

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
//echo "Estamos en: ".$uri."\n";
$uri = explode( '/', $uri );

// all of our endpoints start with /producto
// everything else results in a 404 Not Found
if ($uri[1] !== 'producto') {
    //echo "Entrando Aqui 1";
    //header("HTTP/1.1 404 Not Found");
    //exit();
}

// the producto id is, of course, optional and must be a number:
$productoId = null;
if (isset($uri[2])) {
    $productoId = (int) $uri[2];
    echo "Entrando Aqui 2";
}

$requestMethod = $_SERVER["REQUEST_METHOD"];

// pass the request method and user ID to the PersonController and process the HTTP request:
$controller = new productoController($dbConnection, $requestMethod, $productoId);
$controller->processRequest();