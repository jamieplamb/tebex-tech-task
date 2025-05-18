<?php

namespace App\Contracts;

interface LookupFactoryInterface
{
    /**
     * @param string $platform
     * @return LookupInterface
     */
    public function create(string $platform): LookupInterface;
}
