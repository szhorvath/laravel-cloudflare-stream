<?php

namespace Szhorvath\LaravelCloudflareStream\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Szhorvath\CloudflareStream\StreamSdk
 *
 * @method static \Szhorvath\CloudflareStream\Resources\Token\TokenResource token()
 */
class CfStream extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'cf-stream';
    }
}
