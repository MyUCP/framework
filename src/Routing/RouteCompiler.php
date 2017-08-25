<?php

namespace MyUCP\Routing;

use MyUCP\Container\Container;
use ReflectionFunction;
use MyUCP\Response\Exception\HttpResponseException;

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
     * The container instance.
     *
     * @var \MyUCP\Container\Container
     */
    protected $container;

    /**
     * Create a new Route compiler instance.
     *
     * @param  \MyUCP\Routing\Route $route
     * @param \MyUCP\Container\Container $route
     * @return void
     */
    public function __construct(Route $route, Container $container)
    {
        $this->route = $route;
        $this->container = $container;
    }

    /**
     * Compile the route.
     *
     * @return \MyUCP\Routing\CompiledRoute
     *
     * @throws \MyUCP\Response\Exception\HttpResponseException
     */
    public function compile()
    {
        try {
            if ($this->isControllerAction()) {
                $controller = $this->route->getController();
                $method = $this->route->getControllerMethod();

                return $this->runController($controller, $method);
            }

            return $this->runCallable();
        } catch (HttpResponseException $e) {

            return $e->getResponse();
        }
    }

    /**
     * Get the key / value list of parameters without null values.
     *
     * @return array
     */
    public function parametersWithoutNulls()
    {
        return array_filter($this->route->parameters(), function ($p) {
            return ! is_null($p);
        });
    }

    /**
     * Checks whether the route's action is a controller.
     *
     * @return bool
     */
    protected function isControllerAction()
    {
        return is_string($this->route->action['uses']);
    }

    /**
     * Run the route action and return the response.
     *
     * @return \MyUCP\Routing\CompiledRoute
     */
    protected function runCallable()
    {
        $callable = $this->route->action['uses'];

        return $this->getCompiledResponse($callable(...array_values($this->resolveMethodDependencies(
            $this->parametersWithoutNulls(), new ReflectionFunction($this->route->action['uses'])
        ))));
    }

    /**
     * Run the route action and return the response.
     *
     * @param object $controller
     * @param string $method
     *
     * @return \MyUCP\Routing\CompiledRoute
     *
     * @throws \MyUCP\Response\Exception\NotFoundHttpException
     */
    protected function runController($controller, $method)
    {
        $parameters = $this->resolveClassMethodDependencies(
            $this->route->parametersWithoutNulls(), $controller, $method
        );

        if (method_exists($controller, 'callAction')) {
            return $this->getCompiledResponse($controller->callAction($method, $parameters));
        }

        return $this->getCompiledResponse($controller->{$method}(...array_values($parameters)));
    }

    /**
     * Get Response
     *
     * @param $content
     * @return \MyUCP\Routing\CompiledRoute
     */
    public function getCompiledResponse($content)
    {
        return (new CompiledRoute(
            $this->route,
            $this->container,
            $content
        ));
    }
}