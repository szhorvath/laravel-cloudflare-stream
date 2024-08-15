<?php

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Support\Facades\Route;

Route::prefix('webhooks')->group(function () {
    Route::webhooks('cloudflare-stream', 'cloudflare-stream');
})->withoutMiddleware(VerifyCsrfToken::class);
