<?php

namespace MyUCP\Request\Traits;

trait Post
{
    /**
     * Retrieve an input item from the request.
     *
     * @param  string  $key
     * @param  string|array|null  $default
     * @return string|array
     */
    public function post($key = null, $default = null)
    {
        return data_get(
            $this->request, $key, $default
        );
    }
}