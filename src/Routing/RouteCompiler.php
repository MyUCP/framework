<?php

namespace MyUCP\Routing;

use MyUCP\Request\Request;

class RouteCompiler
{
    use RouteDependencyResolverTrait;

    /**
     * The route instance.
     *
     * @var \MyUCP\Routing\Route
     */
    protected $route;

    /**
     * Create a new Route compiler instance.
     *
     * @param  \MyUCP\Routing\Route $route
     * @return void
     */
    public function __construct($route)
    {
        $this->route = $route;
    }

    /**
     * Compile the route.
     *
     * @param \MyUCP\Request\Request $request
     *
     * @return \MyUCP\Routing\CompiledRoute
     */
    public function compile(Request $request)
    {
        $controller = $this->route->getController();
        $method = $this->route->getControllerMethod();

        $parameters = $this->resolveClassMethodDependencies(
            $this->route->parametersWithoutNulls(), $controller, $method
        );

        if (method_exists($controller, 'callAction')) {
            return $controller->callAction($method, $parameters);
        }

        return (new CompiledRoute(
            $this->route,
            $request,
            $controller->{$method}(...array_values($parameters))
        ))->getResponse();
    }
}