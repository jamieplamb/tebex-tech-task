<?php

namespace App\Services;

use App\Contracts\LookupFactoryInterface;
use App\Contracts\LookupInterface;
use Exception;
use GuzzleHttp\Client;

class PlatformLookupFactory implements LookupFactoryInterface
{
    protected Client $client;

    protected array $platforms = [
        'minecraft' => MinecraftLookup::class,
        'steam' => SteamLookup::class,
        'xbl' => XblLookup::class,
    ];

    /**
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @param string $platform
     * @return LookupInterface
     * @throws Exception
     */
    public function create(string $platform): LookupInterface
    {
        if (! isset($this->platforms[$platform])) {
            throw new Exception("Unsupported Platform: $platform");
        }

        return new $this->platforms[$platform]($this->client);
    }
}
