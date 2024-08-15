<?php

declare(strict_types=1);

use function Pest\Laravel\postJson;

beforeEach(function () {
    config()->set('webhook-client.configs.0.signing_secret', 'a40a54471c07a225fc19ae4803d2e9a69aefac48');

    $this->headers = [
        'Host' => 'example.com',
        'User-Agent' => 'Cloudflare Stream Webhook',
        'Content-Length' => '1220',
        'Content-Type' => 'application/json',
        'webhook-signature' => 'time=1723646181,sig1=7fd16f1875290867a1d1835a94ec44bdae91c5a19627b4eb3001f407593b3afb',
        'webhook-signature-verification-instructions' => 'https://developers.cloudflare.com/stream/',
        'Accept-Encoding' => 'gzip',
        'upgrade-insecure-requests' => '1',
    ];
});

it('should return success', function () {
    postJson(
        uri: '/webhooks/cloudflare-stream',
        data: json_decode(
            json: fixture('webhook/stopped'),
            associative: true,
            flags: JSON_THROW_ON_ERROR,
        ),
        headers: $this->headers
    )
        ->assertOk()
        ->assertExactJson(['message' => 'ok']);
});

it('should fail signature check when request body is altered', function () {
    postJson(
        uri: '/webhooks/cloudflare-stream',
        data: ['body' => 'tempered with'],
        headers: $this->headers
    )
        ->assertStatus(500)
        ->assertExactJson(['message' => 'Server Error']);
});
