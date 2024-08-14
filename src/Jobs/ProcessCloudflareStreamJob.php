<?php

namespace Szhorvath\LaravelCloudflareStream\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Spatie\WebhookClient\Jobs\ProcessWebhookJob;

class ProcessCloudflareStreamJob extends ProcessWebhookJob implements ShouldQueue
{
    public function handle(): void
    {
        ray($this->webhookCall);
    }
}
