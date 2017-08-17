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
     * The request instance.
     *
     * @var \MyUCP\Request\Request
     */
    protected $request;

    /**
     * Create a new Route compiler instance.
     *
     * @param  \MyUCP\Routing\Route $route
     * @return void
     */
    public function __construct($route, Request $request)
    {
        $this->route = $route;
        $this->request = $request;
    }

    /**
     * Compile the route.
     *
     * @param \MyUCP\Request\Request $request
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

        return (new CompiledRoute(
            $this->route,
            $this->request,
            $controller->{$method}(...array_values($parameters))
        ))->getResponse();
    }
}