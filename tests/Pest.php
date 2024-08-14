<?php

use Szhorvath\LaravelCloudflareStream\Tests\TestCase;

uses(TestCase::class)->in(__DIR__);

function fixture(string $name): string
{
    if (! file_exists(filename: __DIR__."/Fixtures/{$name}.json")) {
        throw new InvalidArgumentException(
            message: "Fixture not found [{$name}].",
        );
    }

    return (string) file_get_contents(
        filename: __DIR__."/Fixtures/{$name}.json",
    );
}
