<?php

namespace MyUCP\Interfaces;


interface Core
{
    /**
     * Get the version number of the application.
     *
     * @return string
     */
    public function version();

    /**
     * Get the base path of the Laravel installation.
     *
     * @return string
     */
    public function basePath();

    /**
     * Set the base path for the application.
     *
     * @param $basePath
     * @return $this
     */
    public function setBasePath($basePath);
}