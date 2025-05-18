<?php

namespace App\Contracts;

interface LookupInterface
{
    /**
     * @param string $username
     * @return array
     */
    public function lookupByUsername(string $username): array;

    /**
     * @param string $id
     * @return array
     */
    public function lookupById(string $id): array;

    /**
     * @return bool
     */
    public function canLookupWithUsername(): bool;

    /**
     * @return bool
     */
    public function canLookupWithId(): bool;
}
