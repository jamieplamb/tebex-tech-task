<?php

namespace Tests\Unit\Services;

use App\Exceptions\UnexpectedLookupResponseException;
use App\Services\XblLookup;
use GuzzleHttp\Client;
use Tests\TestCase;

class XblLookupTest extends TestCase
{
    public function test_lookup_by_username()
    {
        $xblLookup = new XblLookup(
            new Client()
        );

        $response = $xblLookup->lookupByUsername('tebex');

        $this->assertEquals('2533274844413377', $response['id']);
        $this->assertEquals('Tebex', $response['username']);
        $this->assertEquals('https://avatar-ssl.xboxlive.com/avatar/2533274844413377/avatarpic-l.png', $response['avatar']);
    }

    public function test_lookup_by_id()
    {
        $xblLookup = new XblLookup(
            new Client()
        );

        $response = $xblLookup->lookupById('2533274884045330');

        $this->assertEquals('2533274884045330', $response['id']);
        $this->assertEquals('d34dmanwalkin', $response['username']);
        $this->assertEquals('https://avatar-ssl.xboxlive.com/avatar/2533274884045330/avatarpic-l.png', $response['avatar']);
    }

    public function test_it_handles_an_unknown_username()
    {
        $xblLookup = new XblLookup(
            new Client()
        );

        $this->expectException(UnexpectedLookupResponseException::class);
        $xblLookup->lookupByUsername('2533274884045330');
    }

    public function test_it_handles_an_unknown_id()
    {
        $xblLookup = new XblLookup(
            new Client()
        );

        $this->expectException(UnexpectedLookupResponseException::class);
        $xblLookup->lookupById('Tebex');
    }
}
