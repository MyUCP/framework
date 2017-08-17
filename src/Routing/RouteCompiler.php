<?php

namespace MyUCP\Routing;

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
     * @return \MyUCP\Routing\CompiledRoute
     */
    public function compile()
    {
        $controller = $this->route->getController();
        $method = $this->route->getControllerMethod();

        $parameters = $this->resolveClassMethodDependencies(
            $this->route->parametersWithoutNulls(), $controller, $method
        );

        if (method_exists($controller, 'callAction')) {
            return $controller->callAction($method, $parameters);
        }

        return $controller->{$method}(...array_values($parameters));
    }
}