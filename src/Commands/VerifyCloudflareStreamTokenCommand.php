<?php

namespace Szhorvath\LaravelCloudflareStream\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'orders:backfill-timestamps')]
class VerifyCloudflareStreamTokenCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    public $signature = 'cloudflare:verify-stream-token';

    /**
     * The console command description.
     *
     * @var string|null
     */
    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
