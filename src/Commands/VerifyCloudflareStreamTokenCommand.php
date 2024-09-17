<?php

namespace Szhorvath\LaravelCloudflareStream\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Attribute\AsCommand;
use Szhorvath\LaravelCloudflareStream\Facades\CloudflareStream;
use Throwable;

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
        $this->comment('Verifying Cloudflare Stream API token...');

        try {
            $response = CloudflareStream::verifyToken();

            if ($response->failed()) {
                $this->error("Failed to verify Cloudflare Stream API token: {$response->error()}");

                return self::FAILURE;
            }

            $this->info('Cloudflare Stream API token verified');

            return self::SUCCESS;
        } catch (Throwable $th) {
            $this->error("Failed to verify Cloudflare Stream API token: {$th->getMessage()}");

            return self::FAILURE;
        }
    }
}
