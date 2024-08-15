<?php

return [
    /**
     * The base URL used with the Cloudflare Stream API.
     */
    'base_url' => env('CLOUDFLARE_STREAM_BASE_URL', 'https://api.cloudflare.com/client/v4/'),

    /**
     * The account ID used to authenticate with the Cloudflare Stream API.
     */
    'account_id' => env('CLOUDFLARE_STREAM_ACCOUNT_ID', null),

    /**
     * The API token used to authenticate with the Cloudflare Stream API.
     *
     *  @see https://dash.cloudflare.com/profile/api-tokens
     */
    'api_token' => env('CLOUDFLARE_STREAM_API_TOKEN', null),

    /**
     * This domain is specific to your Cloudflare account.
     * Use it for all requests to fetch video manifests, thumbnails and embed codes.
     */
    'customer_subdomain' => env('CLOUDFLARE_STREAM_CUSTOMER_SUBDOMAIN', null),

    /**
     * Cloudflare stream webhook configuration.
     */
    'webhook' => [
        /**
         * Enable or disable the Cloudflare Stream webhook client.
         */
        'enabled' => env('CLOUDFLARE_STREAM_WEBHOOK_ENABLED', true),

        /**
         * The secret used to sign the webhook requests.
         *
         * @see https://developers.cloudflare.com/stream/manage-video-library/using-webhooks/#verify-webhook-authenticity
         */
        'signing_secret' => env('CLOUDFLARE_STREAM_WEBHOOK_SIGNING_SECRET', null),

        /**
         * The name of the header that contains the signature.
         */
        'signature_header_name' => env('CLOUDFLARE_STREAM_WEBHOOK_SIGNATURE_HEADER_NAME', 'Webhook-Signature'),
    ],
];
