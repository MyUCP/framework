<?php

namespace MyUCP\Session;

use MyUCP\Support\Str;

class Session
{
    /**
     * Session ID
     *
     * @var string
     */
    protected $id;

    /**
     * Session name
     *
     * @var string
     */
    protected $name;

    /**
     * Session attributes
     *
     * @var array
     */
    protected $attributes;

    /**
     * Session file handler
     *
     * @var FileHandler
     */
    protected $handler;

    /**
     * Session status
     *
     * @var bool
     */
    protected $started = false;

    /**
     * Session constructor.
     *
     * @param string $name
     * @param FileHandler $handler
     * @param string|null $id
     * @return void
     */
    public function __construct($name, FileHandler $handler, $id = null)
    {
        $this->setId($id);
        $this->name = $name;
        $this->handler = $handler;
    }

    /**
     * Get the current session id
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set session id
     *
     * @param string $id
     * @return void
     */
    public function setId($id)
    {
        $this->id = $this->isValid($id) ? $id : $this->generateSessionId();
    }

    /**
     * Determine if this is valid session id
     *
     * @param string $id
     * @return bool
     */
    public function isValid($id)
    {
        return Str::string($id) & ctype_alnum($id) & Str::length($id) === 40;
    }

    /**
     * Generate new random session id
     * @return string
     */
    public  function generateSessionId()
    {
        return Str::random(40);
    }

    /**
     * Get the current session name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set session name
     *
     * @param string $name
     * @return void
     */
    public function setName($name)
    {
        $this->name = $name;
    }
}