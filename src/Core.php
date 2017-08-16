<?php

namespace MyUCP;

use ArrayAccess;
use MyUCP\Container\Container;
use MyUCP\Interfaces\Core as CoreInterface;

class Core extends Container implements CoreInterface {

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

        $this->registerCoreContainerAliases();
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

    /**
     * Get the path to the application "app" directory.
     *
     * @param string $path Optionally, a path to append to the app path
     * @return string
     */
    public function path($path = '')
    {
        return $this->basePath.DIRECTORY_SEPARATOR.'app'.($path ? DIRECTORY_SEPARATOR.$path : $path);
    }

    /**
     * Get the base path of the application.
     *
     * @param string $path Optionally, a path to append to the base path
     * @return string
     */
    public function basePath($path = '')
    {
        return $this->basePath.($path ? DIRECTORY_SEPARATOR.$path : $path);
    }

    /**
     * Register the core class aliases in the container.
     *
     * @return void
     */
    public function registerCoreContainerAliases()
    {
        foreach ([
                    'app'                   =>  \MyUCP\Core::class,
                    'router'                =>  \MyUCP\Routing\Router::class,
                    'config'                =>  \MyUCP\Config\Config::class,
                 ] as $key => $alias) {
            $this->alias($key, $alias);
        }
    }
}