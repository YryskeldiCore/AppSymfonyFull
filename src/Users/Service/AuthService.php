<?php
declare(strict_types=1);

namespace App\Users\Service;

use App\Auth\AccessTokenInterface;
use App\Auth\TokenData;
use App\Auth\TokenDecoderInterface;
use App\Auth\TokenEncoderInterface;
use App\Users\Model\User;
use App\Users\Repository\UsersRepositoryInterface;

/**
 * Class AuthService
 * @package App\Users\Service
 */
class AuthService implements AuthServiceInterface
{
    /**
     * @var UsersRepositoryInterface
     */
    private $usersRepository;
    /**
     * @var TokenEncoderInterface
     */
    private $tokenEncoder;
    /**
     * @var TokenDecoderInterface
     */
    private $tokenDecoder;

    /**
     * AuthService constructor.
     * @param UsersRepositoryInterface $usersRepository
     * @param TokenEncoderInterface $tokenEncoder
     * @param TokenDecoderInterface $tokenDecoder
     */
    public function __construct(
        UsersRepositoryInterface $usersRepository,
        TokenEncoderInterface $tokenEncoder,
        TokenDecoderInterface $tokenDecoder)
    {
        $this->usersRepository = $usersRepository;
        $this->tokenEncoder = $tokenEncoder;
        $this->tokenDecoder = $tokenDecoder;
    }

    /**
     * @param string $email
     * @param string $password
     * @return string
     */
    public function login(string $email, string $password): string
    {
        /** @var User $user */
        $this->verifyPassword($user = $this->usersRepository->oneBy(['email' => $email]), $password);

        $tokenData = new TokenData([
            'id' => $user->getId(),
            'email' => $user->getEmail(),
            'privileges' => $user->getPrivileges()->toArray()
        ]);

        $accessToken = $this->tokenEncoder->encode($tokenData);

        return $accessToken;
    }


    /**
     * @param string $token
     * @return AccessTokenInterface
     */
    public function verify(string $token): AccessTokenInterface
    {
        $accessToken = $this->tokenDecoder->decode($token);

        return $accessToken;
    }

    /**
     * @param User $user
     * @param string $password
     */
    private function verifyPassword(User $user, string $password): void
    {
        if(!$user->verifyPassword($password)){
            throw new \LogicException("Неверный пароль");
        }
    }
}