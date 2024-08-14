<?php

declare(strict_types=1);

namespace Szhorvath\LaravelCloudflareStream\Webhook;

use Illuminate\Http\Request;
use Spatie\WebhookClient\Exceptions\InvalidConfig;
use Spatie\WebhookClient\SignatureValidator\SignatureValidator;
use Spatie\WebhookClient\WebhookConfig;

/**
 * @see https://developers.cloudflare.com/stream/manage-video-library/using-webhooks/#verify-webhook-authenticity
 */
class StreamSignatureValidator implements SignatureValidator
{
    public function isValid(Request $request, WebhookConfig $config): bool
    {
        $signatureContent = $request->header($config->signatureHeaderName);

        if (! $signatureContent) {
            return false;
        }

        $signingSecret = $config->signingSecret;

        if (empty($signingSecret)) {
            throw InvalidConfig::signingSecretNotSet();
        }

        // Parse signature string:  time=1230811200,sig1=60493ec9388b44585a29543bcf0de62e377d4da393246a8b1c901d0e3e672404
        [$time, $signature] = explode(',', $signatureContent);
        $time = explode('=', $time)[1];
        $sig = explode('=', $signature)[1];

        $computedSignature = hash_hmac('sha256', "{$time}.{$request->getContent()}", $signingSecret);

        return hash_equals($computedSignature, $sig);
    }
}
