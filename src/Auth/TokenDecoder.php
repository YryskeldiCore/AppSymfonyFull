<?php
declare(strict_types=1);

namespace App\Auth;


class TokenDecoder implements TokenDecoderInterface
{

    /**
     * @param string $token
     * @return AccessTokenInterface
     */
    public function decode(string $token): AccessTokenInterface
    {
        $arr = explode(".", $token);

        $headers = unserialize(base64_decode($arr[0]));
        $data = unserialize(base64_decode($arr[1]));
        $signature = base64_decode($arr[2]);

        return new AccessToken($headers, $data, $signature);
    }
}