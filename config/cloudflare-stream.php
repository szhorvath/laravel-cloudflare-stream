<?php

return [

    /*
    |--------------------------------------------------------------------------
    | API Token
    |--------------------------------------------------------------------------
    |
    | The API token used to authenticate with the Cloudflare Stream API.
    | @see https://dash.cloudflare.com/profile/api-tokens
    |
    */
    'api_token' => env('CLOUDFLARE_STREAM_API_TOKEN', ''),

    /*
    |--------------------------------------------------------------------------
    | Account ID
    |--------------------------------------------------------------------------
    |
    | The account ID used to authenticate with the Cloudflare Stream API.
    |
    */
    'account_id' => env('CLOUDFLARE_STREAM_ACCOUNT_ID', ''),

    /*
    |--------------------------------------------------------------------------
    | Base URL
    |--------------------------------------------------------------------------
    |
    | The base URL used with the Cloudflare Stream API.
    |
    */
    'base_url' => env('CLOUDFLARE_STREAM_BASE_URL', 'https://api.cloudflare.com/client/v4/'),

    /**
    |--------------------------------------------------------------------------
    | Customer Subdomain
    |--------------------------------------------------------------------------
    |
    | This domain is specific to your Cloudflare account.
    | Use it for all requests to fetch video manifests, thumbnails and embed codes.
    |
     */
    'customer_subdomain' => env('CLOUDFLARE_STREAM_CUSTOMER_SUBDOMAIN', 'customer-<customer_id>.cloudflarestream.com'),

    /*
    |--------------------------------------------------------------------------
    | Signing Key ID
    |--------------------------------------------------------------------------
    | This is the signing Key ID to generate tokens for signed URLs
    | @see https://developers.cloudflare.com/stream/viewing-videos/securing-your-stream/#option-2-generating-signed-tokens-without-calling-the-token-endpoint
    |
    */
    'key_id' => env('CLOUDFLARE_STREAM_KEY_ID', ''),

    /*
    |--------------------------------------------------------------------------
    | Signing key PEM
    |--------------------------------------------------------------------------
    |
    | This is the signing RSA private key in PEM format to generate tokens for signed URLs
    | @see https://developers.cloudflare.com/api/operations/stream-signing-keys-create-signing-keys
    |
    */
    'pem' => env('CLOUDFLARE_STREAM_KEY_PEM', ''),

    /*
    |--------------------------------------------------------------------------
    | Default Options
    |--------------------------------------------------------------------------
    |
    | This is the default options that will be applied to all upload
    | The `thumbnailTimestampPct` is a floating point value between 0.0 and 1.0.
    | All the commented defaults here don't seem to work for uploading via link
    |
    */
    'default_options' => [
        'requireSignedURLs' => true,
        //'allowedOrigins' => [],
        //'thumbnailTimestampPct' => 0.0
    ],

    /*
    |--------------------------------------------------------------------------
    | Webhook
    |--------------------------------------------------------------------------
    |
    | Cloudflare stream webhook configuration.
    | This configuration will be merged with the Spatie Laravel Webhook Client - webhook-client configuration.
    | @see https://github.com/spatie/laravel-webhook-client
    |
    */
    'webhook' => [
        /**
         * Enable or disable the Cloudflare Stream webhook client.
         */
        'enabled' => env('CLOUDFLARE_STREAM_WEBHOOK_ENABLED', true),

        /**
         * Spatie Laravel Webhook Client supports multiple webhook receiving endpoints.
         */
        'name' => 'cloudflare-stream',

        /**
         * The Laravel route URL used to receive Cloudflare Stream webhooks.
         */
        'url' => 'webhooks/cloudflare-stream',

        /**
         * The middleware to be applied to the webhook route.
         */
        'middleware' => [],

        /**
         * The secret used to sign the webhook requests.
         *
         * @see https://developers.cloudflare.com/stream/manage-video-library/using-webhooks/#verify-webhook-authenticity
         */
        'signing_secret' => env('CLOUDFLARE_STREAM_WEBHOOK_SIGNING_SECRET', ''),

        /**
         * The name of the header containing the signature.
         */
        'signature_header_name' => env('CLOUDFLARE_STREAM_WEBHOOK_SIGNATURE_HEADER_NAME', 'Webhook-Signature'),

        /**
         *  This class will verify that the content of the signature header is valid.
         *
         * It should implement \Spatie\WebhookClient\SignatureValidator\SignatureValidator
         */
        'signature_validator' => \Szhorvath\LaravelCloudflareStream\Webhook\StreamSignatureValidator::class,

        /**
         * This class determines if the webhook call should be stored and processed.
         */
        'webhook_profile' => \Spatie\WebhookClient\WebhookProfile\ProcessEverythingWebhookProfile::class,

        /**
         * This class determines the response on a valid webhook call.
         */
        'webhook_response' => \Spatie\WebhookClient\WebhookResponse\DefaultRespondsTo::class,

        /**
         * The classname of the model to be used to store webhook calls. The class should
         * be equal or extend Spatie\WebhookClient\Models\WebhookCall.
         */
        'webhook_model' => \Spatie\WebhookClient\Models\WebhookCall::class,

        /**
         * In this array, you can pass the headers that should be stored on
         * the webhook call model when a webhook comes in.
         *
         * To store all headers, set this value to `*`.
         */
        'store_headers' => '*',

        /**
         * The class name of the job that will process the webhook request.
         *
         * This should be set to a class that extends \Spatie\WebhookClient\Jobs\ProcessWebhookJob.
         */
        'process_webhook_job' => \Szhorvath\LaravelCloudflareStream\Jobs\ProcessCloudflareStreamJob::class,
    ],
];
