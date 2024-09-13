<?php

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Support\Facades\Route;

if (config('cloudflare-stream.webhook.enabled', true)) {
    Route::webhooks(
        url: config('cloudflare-stream.webhook.url', 'webhooks/cloudflare-stream'),
        name: config('cloudflare-stream.webhook.name', 'cloudflare-stream'),
    )
        ->middleware(config('cloudflare-stream.webhook.middleware', []))
        ->withoutMiddleware(VerifyCsrfToken::class);
}
