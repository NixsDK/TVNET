<?php
declare(strict_types=1);

namespace app\Core;

use FastRoute\Dispatcher;
use FastRoute\RouteCollector;
use FastRoute\Dispatcher\GroupCountBased;

class Router
{
    public static function route(array $routes)
    {
        $dispatcher = self::createDispatcher($routes);

        $routeInfo = self::dispatchRoute($dispatcher);

        return self::handleRouteResult($routeInfo);
    }

    private static function createDispatcher(array $routes): Dispatcher
    {
        return \FastRoute\simpleDispatcher(function (RouteCollector $router) use ($routes) {
            foreach ($routes as $route) {
                [$method, $path, $handler] = $route;
                $router->addRoute($method, $path, $handler);
            }
        });
    }

    private static function dispatchRoute(Dispatcher $dispatcher): array
    {
        $httpMethod = $_SERVER['REQUEST_METHOD'];
        $uri = $_SERVER['REQUEST_URI'];

        if (false !== $pos = strpos($uri, '?')) {
            $uri = substr($uri, 0, $pos);
        }
        $uri = rawurldecode($uri);

        return $dispatcher->dispatch($httpMethod, $uri);
    }

    private static function handleRouteResult(array $routeInfo)
    {
        $routeStatus = $routeInfo[0];

        switch ($routeStatus) {
            case Dispatcher::NOT_FOUND:
            case Dispatcher::METHOD_NOT_ALLOWED:
                return self::notFoundView();
            case Dispatcher::FOUND:
                $handler = $routeInfo[1];
                $vars = $routeInfo[2];
                [$controller, $method] = $handler;
                return self::callControllerMethod($controller, $method, $vars);
            default:
                return null;
        }
    }

    private static function notFoundView(): View
    {
        return new View('notFound', []);
    }

    private static function callControllerMethod(string $controller, string $method, array $vars)
    {
        return (new $controller)->{$method}($vars);
    }
}
