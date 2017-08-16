<?php

namespace MyUCP\Request\Traits;

trait CheckMethod
{
    /**
     * Returns whether this is a POST request.
     * @return bool whether this is a POST request.
     */
    public function isPost()
    {
        return $this->isMethod(self::METHOD_POST);
    }

    /**
     * Determine if the request is the result of an AJAX call
     *
     * @return bool whether this is a POST request.
     */
    public function isAjax()
    {
        return $this->ajax();
    }

    /**
     * Returns whether this is a GET request.
     *
     * @return bool whether this is a GET request.
     */
    public function isGet()
    {
        return $this->isMethod(self::METHOD_GET);
    }

    /**
     * Returns whether this is a PUT request.
     * @return bool whether this is a PUT request.
     */
    public function isPut()
    {
        return $this->isMethod(self::METHOD_PUT);
    }
}