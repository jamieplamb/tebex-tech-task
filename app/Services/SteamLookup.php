<?php

namespace App\Services;

use App\Exceptions\UnexpectedLookupResponseException;

class SteamLookup extends PlatformLookup
{
    /**
     * @return bool
     */
    public function canLookupWithUsername(): bool
    {
        return false;
    }

    /**
     * @param string $username
     * @return array
     * @throws UnexpectedLookupResponseException
     */
    protected function usernameLookup(string $username): array
    {
        throw new UnexpectedLookupResponseException('Cannot use usernames for Steam Lookups');
    }

    /**
     * @param string $id
     * @return array
     * @throws UnexpectedLookupResponseException
     */
    protected function idLookup(string $id): array
    {
        $response = $this->makeCall("https://ident.tebex.io/usernameservices/4/username/$id");

        return [
            'id' => $response->id,
            'username' => $response->username,
            'avatar' => $response->meta->avatar
        ];
    }
}
