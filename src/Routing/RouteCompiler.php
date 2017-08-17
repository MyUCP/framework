<?php

namespace MyUCP\Routing;


class RouteCompiler
{
    /**
     * The route instance.
     *
     * @var \MyUCP\Routing\Route
     */
    protected $route;

    /**
     * Create a new Route compiler instance.
     *
     * @param  \MyUCP\Routing\Route  $route
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
        //
    }
}