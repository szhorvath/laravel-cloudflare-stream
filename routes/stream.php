<?php

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Support\Facades\Route;

Route::webhooks('webhook-cloudflare-stream', 'cloudflare-stream')->withoutMiddleware(VerifyCsrfToken::class);
