<?php
declare(strict_types=1);

namespace App\Auth;


interface TokenDecoderInterface
{
    public function decode(string $token): AccessTokenInterface;
}