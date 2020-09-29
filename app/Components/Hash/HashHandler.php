<?php


namespace App\Components\Hash;


use Hashids\Hashids;

class HashHandler implements IHash
{
    protected $hash;

    public function __construct(Hashids $hashIds)
    {
        $this->hash = $hashIds;
    }

    public function encode(int $val)
    {
        return $this->hash->encode($val);
    }

    public function decode(string $hash)
    {
        return $this->hash->decode($hash)[0];
    }

    public function encodeHex(string $val)
    {
        return $this->hash->encodeHex($val);
    }

    public function decodeHex(string $hash)
    {
        return $this->hash->decodeHex($hash);
    }
}
