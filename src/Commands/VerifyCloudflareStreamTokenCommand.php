<?php

namespace Szhorvath\LaravelCloudflareStream\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Attribute\AsCommand;
use Szhorvath\LaravelCloudflareStream\Facades\CloudflareStream;

#[AsCommand(name: 'cloudflare:verify-stream-token')]
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
    public $description = 'Verify Cloudflare Stream API token';

    public function handle(): int
    {
        try {
            $this->comment('Verifying Cloudflare Stream API token...');

            $response = CloudflareStream::verifyToken();

            ray($response);

            $this->info('Cloudflare Stream API token verified');
        } catch (\Exception $e) {
            ray($e);
            $this->error('Failed to verify Cloudflare Stream API token: '.$e->getMessage());

            return self::FAILURE;
        }

        return self::SUCCESS;
    }
}
