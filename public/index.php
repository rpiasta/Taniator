<?php
require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

use App\Constraints\HttpStatus;
use App\Controller\Factory\Biedronka\BiedronkaLoginControllerFactory;
use App\Controller\Factory\Biedronka\BiedronkaTokenControllerFactory;
use App\Controller\Factory\ProductControllerFactory;
use App\Controller\Factory\User\LoginControllerFactory;
use App\Controller\Factory\User\RegsterControllerFactory;
use App\Core\Http\Request;
use App\Core\Router;

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(HttpStatus::OK->value);
    exit();
}

$router = new Router();
$router->add('GET', '/api/product', ProductControllerFactory::create());
$router->add('GET', '/api/biedronka/token', BiedronkaTokenControllerFactory::create());
$router->add('GET', '/api/biedronka/login', BiedronkaLoginControllerFactory::create());

$router->add('POST', '/api/users/register', RegsterControllerFactory::create());
$router->add('POST', '/api/users/login', LoginControllerFactory::create());

$request = new Request();
$response = $router->dispatch($request);
$response->send();
