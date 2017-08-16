<?php

namespace MyUCP\Request\Traits;

use MyUCP\Support\Str;

trait Url
{
    /**
     * Get the root URL for the application.
     *
     * @return string
     */
    public function root()
    {
        return rtrim($this->getSchemeAndHttpHost().$this->getBaseUrl(), '/');
    }

    /**
     * Get the URL (no query string) for the request.
     *
     * @return string
     */
    public function url()
    {
        return rtrim(preg_replace('/\?.*/', '', $this->getUri()), '/');
    }

    /**
     * Get the full URL for the request.
     *
     * @return string
     */
    public function fullUrl()
    {
        $query = $this->getQueryString();
        $question = $this->getBaseUrl().$this->getPathInfo() == '/' ? '/?' : '?';
        return $query ? $this->url().$question.$query : $this->url();
    }

    /**
     * Get the full URL for the request with the added query string parameters.
     *
     * @param  array  $query
     * @return string
     */
    public function fullUrlWithQuery(array $query)
    {
        $question = $this->getBaseUrl().$this->getPathInfo() == '/' ? '/?' : '?';
        return count($this->query()) > 0
            ? $this->url().$question.http_build_query(array_merge($this->query(), $query))
            : $this->fullUrl().$question.http_build_query($query);
    }

    /**
     * Determine if the current request URL and query string matches a pattern.
     *
     * @return bool
     */
    public function fullUrlIs()
    {
        $url = $this->fullUrl();
        foreach (func_get_args() as $pattern) {
            if (Str::is($pattern, $url)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Get the current path info for the request.
     *
     * @return string
     */
    public function path()
    {
        $pattern = trim($this->getPathInfo(), '/');
        return $pattern == '' ? '/' : $pattern;
    }

    /**
     * Get the current encoded path info for the request.
     *
     * @return string
     */
    public function decodedPath()
    {
        return rawurldecode($this->path());
    }

    /**
     * Determine if the current request URI matches a pattern.
     *
     * @return bool
     */
    public function is()
    {
        foreach (func_get_args() as $pattern) {
            if (Str::is($pattern, $this->decodedPath())) {
                return true;
            }
        }
        return false;
    }
}