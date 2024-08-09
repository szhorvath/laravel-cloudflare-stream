<?php

namespace Szhorvath\LaravelCloudflareStream\Commands;

use Illuminate\Console\Command;

class LaravelCloudflareStreamCommand extends Command
{
    public $signature = 'laravel-cloudflare-stream';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
