<?php
declare(strict_types=1);

use app\Core\Renderer;
use app\Core\Router;

require_once '../vendor/autoload.php';
$routes = require_once '../routes.php';
$router = new Router($routes);

$path = $router->resolve();

$renderer = new Renderer();
$content = $renderer->render($path);

echo $content;
