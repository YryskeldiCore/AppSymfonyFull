<?php
declare(strict_types=1);

namespace App\Auth;


interface TokenEncoderInterface
{
    public function encode(TokenDataInterface $data): string;
}