<?php

namespace MyUCP\Routing;

use MyUCP\Container\Container;
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
     * @var \MyUCP\Container\Container
     */
    private $container;

    /**
     * @var \MyUCP\Response\Response
     */
    private $response;

    /**
     * CompiledRoute constructor.
     *
     * @param \MyUCP\Routing\Route $route
     * @param \MyUCP\Container\Container $container
     * @param $compileResult
     *
     * @return CompiledRoute
     */
    public function __construct(Route $route, Container $container, $compileResult)
    {
        $this->uri = $route->uri();
        $this->parameters = $route->parameters();
        $this->container = $container;
        $this->response = $container['response'];

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