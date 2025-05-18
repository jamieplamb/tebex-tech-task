<?php

namespace App\Services;

use App\Exceptions\UnexpectedLookupResponseException;

class MinecraftLookup extends PlatformLookup
{
    /**
     * @param string $username
     * @return array
     * @throws UnexpectedLookupResponseException
     */
    protected function usernameLookup(string $username): array
    {
        $response = $this->makeCall("https://api.mojang.com/users/profiles/minecraft/$username");

        return [
            'id' => $response->id,
            'username' => $response->name,
            'avatar' => "https://crafatar.com/avatars/$response->id"
        ];
    }

    /**
     * @param string $id
     * @return array
     * @throws UnexpectedLookupResponseException
     */
    protected function idLookup(string $id): array
    {
        $response = $this->makeCall("https://sessionserver.mojang.com/session/minecraft/profile/$id");

        return [
            'id' => $response->id,
            'username' => $response->name,
            'avatar' => "https://crafatar.com/avatars/$response->id"
        ];
    }
}
