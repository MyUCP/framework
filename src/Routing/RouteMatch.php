<?php

namespace MyUCP\Routing;


use MyUCP\Request\Request;

class RouteMatch
{

    /**
     * @param Route $route
     * @param Request $request
     */
    public function parseUri(Route $route, Request $request)
    {
        $regex = '/^' . preg_replace('/\//', '\/', $route) .  '\/?$/';
    }
}