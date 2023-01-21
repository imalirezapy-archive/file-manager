<?php
$routesMap = [
    'get' => [],
    'post' => [],
    'put' => [],
    'delete' => [],
    'patch' => []
];


function get(string $url, $callback)
{
    global $routesMap;

    $routesMap['get'][$url] = $callback;
}


function post(string $url, $callback)
{
    global $routesMap;
    $routesMap['post'][$url] = $callback;
}


function delete(string $url, $callback)
{
    global $routesMap;
    $routesMap['delete'][$url] = $callback;
}


function put(string $url, $callback)
{
    global $routesMap;
    $routesMap['put'][$url] = $callback;
}


function patch(string $url, $callback)
{
    global $routesMap;
    $routesMap['patch'][$url] = $callback;
}


function getCallbackFromDynamicRoute()
{
    global $routesMap;

    $method = getMethod();
    $url = getUrl();

    $routes = $routesMap[$method];

    foreach ($routes as $route => $callback) {
        $routeNames = [];
        if (!$route) {
            continue;
        }

        if (preg_match_all('/\{(\w+)(:[^}]+)?}/', $route, $matches)) {
            $routeNames = $matches[1];
        }

        $routeRegex = convertRouteToRegex($route);

        if (preg_match_all($routeRegex, $url, $matches)) {
            $values = [];
            unset($matches[0]);
            foreach ($matches as $match) {
                $values[] = $match[0];
            }


            $routeParams = array_combine($routeNames, $values);


            return [$callback, $routeParams];
        }



    }

    return false;
}


function solve()
{
    global $routesMap;

    $method = getMethod();
    $url = getUrl();

    $callback = $routesMap[$method][$url] ?? false;
    $params = [];
    if (!$callback) {

        $routeCallback = getCallbackFromDynamicRoute();

        if (!$routeCallback) {
            throw new Exception('not found');
        }

        $callback = $routeCallback[0];
        $params = $routeCallback[1];
    }
    return call_user_func($callback, ...array_values($params));
}


function convertRouteToRegex(string $route) : string
{

    return "@^" . preg_replace_callback(
        '/\{\w+(:([^}]+))?}/',
        fn($m) => isset($m[2]) ? "($m[2])" : '([-\w]+)',
        $route
    ) . "$@";


}