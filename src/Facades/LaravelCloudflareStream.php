<?php

namespace Szhorvath\LaravelCloudflareStream\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Szhorvath\LaravelCloudflareStream\LaravelCloudflareStream
 */
class LaravelCloudflareStream extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Szhorvath\LaravelCloudflareStream\LaravelCloudflareStream::class;
    }
}
