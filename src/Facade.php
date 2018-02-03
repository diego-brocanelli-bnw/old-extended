<?php 

namespace LaravelFormHelpers;

class Facade extends \Illuminate\Support\Facades\Facade
{
    /**
     * {@inheritDoc}
     */
    protected static function getFacadeAccessor()
    {
        return Accessor::class;
    }
}
