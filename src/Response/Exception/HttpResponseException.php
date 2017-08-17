<?php
/**
 * Created by PhpStorm.
 * User: Максим
 * Date: 18.08.2017
 * Time: 0:20
 */

namespace MyUCP\Response\Exception;

use RuntimeException;
use MyUCP\Response\Response;

class HttpResponseException extends RuntimeException
{
    /**
     * The underlying response instance.
     *
     * @var \MyUCP\Response\Response
     */
    protected $response;

    /**
     * Create a new HTTP response exception instance.
     *
     * @param  \MyUCP\Response\Response  $response
     * @return void
     */
    public function __construct(Response $response)
    {
        $this->response = $response;
    }

    /**
     * Get the underlying response instance.
     *
     * @return \MyUCP\Response\Response
     */
    public function getResponse()
    {
        return $this->response;
    }
}