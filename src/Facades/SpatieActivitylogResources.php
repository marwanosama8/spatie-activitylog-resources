<?php

namespace Marwanosama8\SpatieActivitylogResources\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Marwanosama8\SpatieActivitylogResources\SpatieActivitylogResources
 */
class SpatieActivitylogResources extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Marwanosama8\SpatieActivitylogResources\SpatieActivitylogResources::class;
    }
}
