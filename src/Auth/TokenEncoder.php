<?php
declare(strict_types=1);

namespace App\Auth;


class TokenEncoder implements TokenEncoderInterface
{

    private $headers;

    private $secret;

    public function __construct(TokenHeadersInterface $headers, string $secret)
    {
        $this->headers = $headers;
        $this->secret = $secret;
    }


    public function encode(TokenDataInterface $data): string
    {
        $h = base64_encode(serialize($this->headers));
        $b =  base64_encode(serialize($data));

        $s = base64_encode(
            hash($this->headers->getAlg(),
                serialize($this->headers) . serialize($data) . $this->secret));

        return $this->concat($h, $b, $s);
    }

    private function concat(string...$args): string
    {
        $result = "";
        foreach ($args as $arg){
            $result .= $arg . ".";
        }

        return trim($result, ".");
    }
}