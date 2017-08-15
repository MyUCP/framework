<?php

namespace MyUCP;

class Core {

    /*
     * MyUCP framework version
     *
     * @var string
     */
    const VERSION = '6.0.1';

    /**
     * The base path for the MyUCP installation.
     *
     * @var string
     */
    protected $basePath;

    /**
     * Create a new Illuminate application instance.
     *
     * @param  $basePath
     * @return void
     */
    public function __construct($basePath = null)
    {
        if ($basePath) {
            $this->setBasePath($basePath);
        }
    }

    /**
     * Get the version number of the application.
     *
     * @return string
     */
    public function version()
    {
        return static::VERSION;
    }

    /**
     * Set the base path for the application.
     *
     * @param $basePath
     * @return $this
     */
    public function setBasePath($basePath)
    {
        $this->basePath = rtrim($basePath, '\/');
        return $this;
    }

}