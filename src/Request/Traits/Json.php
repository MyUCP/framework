<?php

namespace MyUCP\Request\Traits;

use MyUCP\Support\Str;
use MyUCP\Request\ParameterBag;

trait Json
{
    /**
     * The decoded JSON content for the request.
     *
     * @var string
     */
    protected $json;

    /**
     * Get the JSON payload for the request.
     *
     * @param  string  $key
     * @param  mixed   $default
     * @return mixed
     */
    public function json($key = null, $default = null)
    {
        if (! isset($this->json)) {
            $this->json = new ParameterBag((array) json_decode($this->getContent(), true));
        }

        if (is_null($key)) {
            return $this->json;
        }

        return data_get($this->json->all(), $key, $default);
    }

    /**
     * Set the JSON payload for the request.
     *
     * @param  array  $json
     * @return $this
     */
    public function setJson($json)
    {
        $this->json = $json;
        return $this;
    }

    /**
     * Determine if the request is sending JSON.
     *
     * @return bool
     */
    public function isJson()
    {
        return Str::contains($this->header('CONTENT_TYPE'), ['/json', '+json']);
    }
    /**
     * Determine if the current request probably expects a JSON response.
     *
     * @return bool
     */
    public function expectsJson()
    {
        return ($this->ajax() && ! $this->pjax()) || $this->wantsJson();
    }
    /**
     * Determine if the current request is asking for JSON in return.
     *
     * @return bool
     */
    public function wantsJson()
    {
        $acceptable = $this->getAcceptableContentTypes();
        return isset($acceptable[0]) && Str::contains($acceptable[0], ['/json', '+json']);
    }
}