<?php

namespace Framework;

use App\Controllers\Errors\ErrorController;

class Router {
    protected array $routes = [];

    /**
     * Helper method to register routes
     *
     * @param $method
     * @param $uri
     * @param $action
     * @return void
     */

    public function registerRoute($method, $uri, $action): void
    {
        list($controller, $controllerMethod) = explode('@', $action);

        $this->routes[] = [
            'method' => $method,
            'uri' => $uri,
            'controller' => $controller,
            'controllerMethod' => $controllerMethod
        ];
    }

    /**
     * Add a GET route
     *
     * @param string $uri
     * @param string $controller
     * @return void
     */
    public function get(string $uri, string $controller): void
    {
        $this->registerRoute('GET', $uri, $controller);
    }

    /**
     * Add a POST route
     *
     * @param string $uri
     * @param string $controller
     * @return void
     */

    public function post(string $uri, string $controller): void
    {
        $this->registerRoute('POST', $uri, $controller);
    }

    /**
     * Add a PUT route
     *
     * @param string $uri
     * @param string $controller
     * @return void
     */

    public function put(string $uri, string $controller): void
    {
        $this->registerRoute('PUT', $uri, $controller);
    }

    /**
     * Add a DELETE route
     *
     * @param string $uri
     * @param string $controller
     * @return void
     */

    public function delete(string $uri, string $controller): void
    {
        $this->registerRoute('DELETE', $uri, $controller);
    }

    /**
     * Route the request
     *
     * @param string $uri
     * @return void
     */

    public function route(string $uri): void
    {
        $requestMethod = $_SERVER['REQUEST_METHOD'];

        if($requestMethod === 'POST' && isset($_POST['_method'])) {
            $requestMethod = strtoupper($_POST['_method']);
        }

        foreach ($this->routes as $route) {
            $uriParts = explode('/', trim($uri, '/'));
            $routeParts = explode('/', trim($route['uri'], '/'));
            $match = true;

            // if the number of parts matches
            if (count($uriParts) === count($routeParts) && strtoupper(
                    $route['method'] === $requestMethod)) {
                $params = [];

                $match = true;

                for ($i = 0; $i < count($uriParts); $i++) {
                    // If the uri's do not match and there is no param
                    if ($routeParts[$i] !== $uriParts[$i] && !preg_match('/\{(.+?)\}/', $routeParts[$i])) {
                        $match = false;
                        break;
                    }

                    // Check for the param and add to $params array
                    if (preg_match('/\{(.+?)\}/', $routeParts[$i], $matches)) {
                        $params[$matches[1]] = $uriParts[$i];
                    }
                }
                if ($match) {
                    $controller = 'App\\Controllers\\' . $route['controller'];
                    $controllerMethod = $route['controllerMethod'];

                    // Instantiate the controller and call the method
                    $controllerInstance = new $controller();
                    $controllerInstance->$controllerMethod($params);
                    return;
                }
            }
        }
        ErrorController::notFound();
    }

}