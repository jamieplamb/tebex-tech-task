<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LookupResource extends JsonResource
{
    /**
     * @param $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this['id'],
            'username' => $this['username'],
            'avatar' => $this['avatar']
        ];
    }
}
