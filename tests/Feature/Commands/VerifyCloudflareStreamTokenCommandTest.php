<?php

declare(strict_types=1);

namespace Tests\Feature\Commands;

use Szhorvath\LaravelCloudflareStream\Facades\CloudflareStream;

use function Pest\Laravel\artisan;

it('can verify Cloudflare Stream API token', function () {
    CloudflareStream::fake([
        [
            'result' => ['id' => '7d8f6ed5fd0843d3ae33919c06917fab', 'status' => 'active'],
            'success' => true,
            'errors' => [],
            'messages' => [
                [
                    'code' => 10000,
                    'message' => 'This API Token is valid and active',
                    'type' => null,
                ],
            ],
        ],
    ]);

    artisan('cloudflare:verify-stream-token')
        ->expectsOutput('Cloudflare Stream API token verified')
        ->assertSuccessful();
});
