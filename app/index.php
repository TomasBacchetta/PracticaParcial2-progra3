<?php

/*
BACCHETTA, TOMÁS
TP PROGRAMACION 3 "LA COMANDA"
SPRINT 1
ALTA
VISUALIZACION
BASE DE DATOS

*/

error_reporting(-1);
ini_set('display_errors', 1);

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Factory\AppFactory;
use Slim\Routing\RouteCollectorProxy;
use Slim\Routing\RouteContext;

require __DIR__ . '/../vendor/autoload.php';

require_once "./db/AccesoDatos.php";

require_once "./Models/Usuario.php";
require_once "./Controllers/UsuarioController.php";
require_once './Controllers/LoginController.php';
require_once "./Models/CriptoMoneda.php";
require_once "./Controllers/CriptoMonedaController.php";
require_once "./Models/VentaCripto.php";
require_once "./Controllers/VentaCriptoController.php";

require_once './MiddleWare/AutentificadorJWT.php';
require_once './MiddleWare/MiddlewareJWT.php';
require_once './MiddleWare/Logger.php';
require_once './MiddleWare/ValidadorParams.php';





// Load ENV
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

// Instantiate App
$app = AppFactory::create();

// Add error middleware
$app->addErrorMiddleware(true, true, true);

$app->group("/usuarios", function (RouteCollectorProxy $group) {
    $group->get('/json', \UsuarioController::class . ':TraerTodos');
    $group->get('/json/pornombrecripto/{nombrecripto}', \UsuarioController::class . ':TraerTodosPorNombreCripto');
    $group->get('/json/porid/{id}', \UsuarioController::class . ':TraerUno');
    $group->post('[/]', \UsuarioController::class . ':CargarUno')->add(\ValidadorParams::class . ':ValidarUsuarioUnico');
    $group->post('/{id}', \UsuarioController::class . ':ModificarUno');
    $group->delete('/{id}', \UsuarioController::class . ':BorrarUno');
})->add(\Logger::class . ':VerificarAdmin')->add(\MiddlewareJWT::class . ':ValidarTokenUsuarios');

$app->group("/criptos", function (RouteCollectorProxy $group) {
  $group->get('[/]', \CriptoMonedaController::class . ':TraerTodos');
  $group->get('/filtrarpornacionalidad/{nacionalidad}', \CriptoMonedaController::class . ':TraerTodosDeUnaNacionalidad');
  $group->get('/filtrarporid/{id}', \CriptoMonedaController::class . ':TraerUno')->add(\MiddlewareJWT::class . ':ValidarTokenUsuarios');
  $group->post('[/]', \CriptoMonedaController::class . ':CargarUno')->add(\Logger::class . ':VerificarAdmin')->add(\MiddlewareJWT::class . ':ValidarTokenUsuarios');
  $group->post('/{id}', \CriptoMonedaController::class . ':ModificarUno')->add(\Logger::class . ':VerificarAdmin')->add(\MiddlewareJWT::class . ':ValidarTokenUsuarios');
  $group->delete('/{id}', \CriptoMonedaController::class . ':BorrarUno')->add(\Logger::class . ':VerificarAdmin')->add(\MiddlewareJWT::class . ':ValidarTokenUsuarios');
});

$app->group("/ventas", function (RouteCollectorProxy $group) {
  $group->get('/json', \VentaCriptoController::class . ':TraerTodos')->add(\Logger::class . ':VerificarAdmin');
  $group->get('/json/nacioyfechas', \VentaCriptoController::class . ':TraerVentasPorNacionalidadEntreDosFechas')->add(\Logger::class . ':VerificarAdmin');
  $group->get('/pdf', \VentaCriptoController::class . ':TraerTodosPDF')->add(\Logger::class . ':VerificarAdmin');
  $group->get('/json/solo/{id}', \VentaCriptoController::class . ':TraerUno');
  $group->post('[/]', \VentaCriptoController::class . ':CargarUno');
})->add(\MiddlewareJWT::class . ':ValidarTokenUsuarios');

$app->group('/login', function (RouteCollectorProxy $group) {
  $group->post('[/]', \LoginController::class . ':VerificarUsuario');
});

$app->get('[/]', function (Request $request, Response $response) {
    $response->getBody()->write("PRACTICA PARCIAL 2");
    return $response;
  });

  $app->run();

?>