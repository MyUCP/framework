<?php

namespace MyUCP\Aliases;

class Config extends Alias
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getAliasAccessor()
    {
        return 'config';
    }
}