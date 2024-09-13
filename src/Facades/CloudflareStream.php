<?php

namespace Szhorvath\LaravelCloudflareStream\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Szhorvath\CloudflareStream\StreamSdk
 *
 * @method static \Szhorvath\CloudflareStream\Resources\Token\TokenResource token()
 */
class CloudflareStream extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'cloudflare-stream';
    }

    public static function fake($callback = null)
    {
        return tap(static::getFacadeRoot(), function ($fake) use ($callback) {
            static::swap($fake->fake($callback));
        });
    }
}
