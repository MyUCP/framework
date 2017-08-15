<?php

namespace MyUCP\Aliases;

use RuntimeException;

class Alias
{
    /*
    * The core instance.
    *
    * @var \MyUCP\Core
    */
    protected static $app;

    /*
     * The resolved object instances
     */
    protected static $aliasInstance;

    /**
     * Get the core instance.
     *
     * @return \MyUCP\Core
     */
    public static function getAliasApplication()
    {
        return static::$app;
    }

    /**
     * Set the core instance.
     *
     * @param  \MyUCP\Core $app
     * @return void
     */
    public static function setAliasApplication($app)
    {
        static::$app = $app;
    }

    /**
     * Resolve the alias root instance.
     *
     * @param  string|object  $name
     * @return mixed
     */
    protected static function resolveAliasInstance($name)
    {
        if (is_object($name)) {
            return $name;
        }

        if (isset(static::$aliasInstance[$name])) {
            return static::$aliasInstance[$name];
        }

        return static::$aliasInstance[$name] = static::$app[$name];
    }

    /**
     * Get the root object.
     *
     * @return mixed
     */
    public static function getAliasRoot()
    {
        return static::resolveAliasInstance(static::getAliasAccessor());
    }

    /**
     * Get the registered name of the component.
     *
     * @return string
     *
     * @throws \RuntimeException
     */
    protected static function getAliasAccessor()
    {
        throw new RuntimeException('Facade does not implement getAliasAccessor method.');
    }

    /**
     * Handle dynamic, static calls to the object.
     *
     * @param  string  $method
     * @param  array   $args
     * @return mixed
     *
     * @throws \RuntimeException
     */
    public static function __callStatic($method, $args)
    {
        $instance = static::getAliasRoot();

        if (! $instance) {
            throw new RuntimeException('A facade root has not been set.');
        }

        return $instance->$method(...$args);
    }
}