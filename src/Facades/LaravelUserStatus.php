<?php

namespace BrianLogan\LaravelUserStatus\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \BrianLogan\LaravelUserStatus\LaravelUserStatus
 */
class LaravelUserStatus extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \BrianLogan\LaravelUserStatus\LaravelUserStatus::class;
    }
}
