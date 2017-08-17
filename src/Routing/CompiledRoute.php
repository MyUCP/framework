<?php

namespace MyUCP\Routing;

use MyUCP\Request\Request;
use MyUCP\Response\Response;
use Serializable;

class CompiledRoute implements Serializable
{
    /**
     * @var string
     */
    private $uri;

    /**
     * @var array
     */
    private $parameters;

    /**
     * @var \MyUCP\Response\Response
     */
    private $response;

    /**
     * CompiledRoute constructor.
     *
     * @param Route $route
     * @param Request $request
     * @param $compileResult
     *
     * @return CompiledRoute
     */
    public function __construct(Route $route, Request $request, $compileResult)
    {
        $this->uri = $route->uri();
        $this->parameters = $route->parameters();
        $this->response = Response::create($compileResult)->prepare($request);

        return $this;
    }

    /**
     * Get Response
     *
     * @return mixed
     */
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