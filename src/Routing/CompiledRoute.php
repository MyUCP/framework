<?php

namespace MyUCP\Routing;

use MyUCP\Request\Request;
use MyUCP\Response\Response;
use Serializable;

class CompiledRoute implements Serializable
{
    private $uri;
    private $parameters;
    private $response;

    public function __construct(Route $route, Request $request, $compileResult)
    {
        $this->uri = $route->uri();
        $this->parameters = $route->parameters();
        $this->response = Response::create($compileResult)->prepare($request);

        return $this;
    }

    public function getResponse()
    {
        return $this->response->send();
    }

    /**
     * {@inheritdoc}
     */
    public function serialize()
    {
        return serialize([
            'uri'           =>  $this->uri,
            'parameters'    =>  $this->parameters,
        ]);
    }
    /**
     * {@inheritdoc}
     */
    public function unserialize($serialized)
    {
        $data = unserialize($serialized, ['allowed_classes' => false]);
        $this->uri = $data['uri'];
        $this->parameters = $data['parameters'];
    }
}