<?php

namespace MyUCP\Aliases;

class Route extends Alias
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getAliasAccessor()
    {
        return 'router';
    }
}