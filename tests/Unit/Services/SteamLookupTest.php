<?php

namespace Tests\Unit\Services;

use App\Exceptions\UnsupportedLookupTypeException;
use App\Services\SteamLookup;
use GuzzleHttp\Client;
use Tests\TestCase;

class SteamLookupTest extends TestCase
{
    public function test_lookup_by_id()
    {
        $steamLookup = new SteamLookup(
            new Client()
        );

        $response = $steamLookup->lookupById('76561198806141009');

        $this->assertEquals('76561198806141009', $response['id']);
        $this->assertEquals('Tebex', $response['username']);
        $this->assertEquals('https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/c8/c86f94b0515600e8f6ff869d13394e05cfa0cd6a.jpg', $response['avatar']);;
    }

    public function test_it_handles_a_username_lookup()
    {
        $steamLookup = new SteamLookup(
            new Client()
        );

        $this->expectException(UnsupportedLookupTypeException::class);
        $steamLookup->lookupByUsername('Tebex');
    }
}
