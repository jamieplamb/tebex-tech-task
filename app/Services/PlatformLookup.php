<?php

namespace App\Services;

use App\Contracts\LookupInterface;
use App\Exceptions\UnexpectedLookupResponseException;
use App\Exceptions\UnsupportedLookupTypeException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Cache;
use Psr\Http\Message\ResponseInterface;

abstract class PlatformLookup implements LookupInterface
{
    protected Client $client;

    protected int $cacheTtl = 3600; // One day

    /**
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @param string $username
     * @return array
     * @throws UnsupportedLookupTypeException
     */
    public function lookupByUsername(string $username): array
    {
        if (! $this->canLookupWithUsername()) {
            throw new UnsupportedLookupTypeException();
        }

        return Cache::remember("lookup_$username", $this->cacheTtl, function () use ($username) {
            return $this->usernameLookup($username);
        });
    }

    /**
     * @param string $id
     * @return array
     * @throws UnsupportedLookupTypeException
     */
    public function lookupById(string $id): array
    {
        if (! $this->canLookupWithId()) {
            throw new UnsupportedLookupTypeException();
        }

        return Cache::remember("lookup_$id", $this->cacheTtl, function () use ($id) {
            return $this->idLookup($id);
        });
    }

    /**
     * @return bool
     */
    public function canLookupWithUsername(): bool
    {
        return true;
    }

    /**
     * @return bool
     */
    public function canLookupWithId(): bool
    {
        return true;
    }

    /**
     * @param string $username
     * @return array
     */
    abstract protected function usernameLookup(string $username): array;

    /**
     * @param string $id
     * @return array
     */
    abstract protected function idLookup(string $id): array;

    /**
     * @param string $url
     * @return mixed
     * @throws UnexpectedLookupResponseException
     */
    protected function makeCall(string $url): mixed
    {
        try {
            return $this->parseResponse(
                $this->client->get($url)
            );
        } catch (GuzzleException $e) {
            throw new UnexpectedLookupResponseException("Lookup Failed with message: " . $e->getMessage());
        }
    }

    /**
     * @param ResponseInterface $response
     * @return mixed
     */
    protected function parseResponse(ResponseInterface $response): mixed
    {
        return json_decode(
            $response->getBody()->getContents()
        );
    }
}
