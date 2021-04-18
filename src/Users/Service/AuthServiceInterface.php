<?php
declare(strict_types=1);

namespace App\Users\Service;


use App\Auth\AccessTokenInterface;

interface AuthServiceInterface
{
    /**
     * @param string $email
     * @param string $password
     * @return string
     */
    public function login(string $email, string $password): string;

    /**
     * @param string $token
     * @return AccessTokenInterface
     */
    public function verify(string $token): AccessTokenInterface;
}