<?php


namespace App\Components\Hash;


interface IHash
{
    public function encode(int $val);

    public function decode(string $hash);

    public function encodeHex(string $val);

    public function decodeHex(string $hash);
}
