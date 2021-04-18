<?php
declare(strict_types=1);

namespace App\Auth;


interface AccessTokenInterface
{
    public function isVerify(): bool;

    public function getData(): TokenDataInterface;

    public function getHeaders(): TokenHeadersInterface;

}