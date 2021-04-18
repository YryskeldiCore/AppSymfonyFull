<?php
declare(strict_types=1);

namespace App\Auth;


class AccessToken implements AccessTokenInterface
{
    private $headers;
    private $data;
    private $sign;

    public function __construct(TokenHeadersInterface $headers, TokenDataInterface $data, string $sign)
    {
        $this->headers = $headers;
        $this->data = $data;
        $this->sign = $sign;
    }


    public function isVerify(): bool
    {
        $s = base64_encode(
            hash($this->headers->getAlg(),
                serialize($this->headers) . serialize($this->data) . $_ENV['APP_SECRET']));

        return $s === $this->sign;
    }

    /**
     * @return TokenHeadersInterface
     */
    public function getHeaders(): TokenHeadersInterface
    {
        return $this->headers;
    }

    /**
     * @return TokenDataInterface
     */
    public function getData(): TokenDataInterface
    {
        return $this->data;
    }


}