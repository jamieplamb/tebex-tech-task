<?php

namespace Tests\Unit\Services;

use App\Exceptions\UnexpectedLookupResponseException;
use App\Services\MinecraftLookup;
use GuzzleHttp\Client;
use Tests\TestCase;

class MinecraftLookupTest extends TestCase
{
    public function test_lookup_by_username()
    {
        $minecraftLookup = new MinecraftLookup(
            new Client()
        );

        $response = $minecraftLookup->lookupByUsername('Notch');

        $this->assertEquals('069a79f444e94726a5befca90e38aaf5', $response['id']);
        $this->assertEquals('Notch', $response['username']);
        $this->assertEquals('https://crafatar.com/avatars/069a79f444e94726a5befca90e38aaf5', $response['avatar']);
    }

    public function test_lookup_by_id()
    {
        $minecraftLookup = new MinecraftLookup(
            new Client()
        );

        $response = $minecraftLookup->lookupById('d8d5a9237b2043d8883b1150148d6955');

        $this->assertEquals('d8d5a9237b2043d8883b1150148d6955', $response['id']);
        $this->assertEquals('Test', $response['username']);
        $this->assertEquals('https://crafatar.com/avatars/d8d5a9237b2043d8883b1150148d6955', $response['avatar']);
    }

    public function test_it_handles_an_unknown_username()
    {
        $minecraftLookup = new MinecraftLookup(
            new Client()
        );

        $this->expectException(UnexpectedLookupResponseException::class);
        $minecraftLookup->lookupByUsername('d8d5a9237b2043d8883b1150148d6955');
    }

    public function test_it_handles_an_unknown_id()
    {
        $minecraftLookup = new MinecraftLookup(
            new Client()
        );

        $this->expectException(UnexpectedLookupResponseException::class);
        $minecraftLookup->lookupById('Notch');
    }
}
