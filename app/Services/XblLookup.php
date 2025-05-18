<?php

namespace App\Services;

use App\Exceptions\UnexpectedLookupResponseException;
use App\Services\PlatformLookup;

class XblLookup extends PlatformLookup
{
    /**
     * @param string $username
     * @return array
     * @throws UnexpectedLookupResponseException
     */
    protected function usernameLookup(string $username): array
    {
        $response = $this->makeCall("https://ident.tebex.io/usernameservices/3/username/$username?type=username");

        return [
            'id' => $response->id,
            'username' => $response->username,
            'avatar' => $response->meta->avatar
        ];
    }

    /**
     * @param string $id
     * @return array
     * @throws UnexpectedLookupResponseException
     */
    protected function idLookup(string $id): array
    {
        $response = $this->makeCall("https://ident.tebex.io/usernameservices/3/username/$id");

        return [
            'id' => $response->id,
            'username' => $response->username,
            'avatar' => $response->meta->avatar
        ];
    }
}
