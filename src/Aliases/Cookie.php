<?php

namespace MyUCP\Aliases;

class Cookie extends Alias
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getAliasAccessor()
    {
        return 'cookie';
    }
}