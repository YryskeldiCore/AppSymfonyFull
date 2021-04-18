<?php
declare(strict_types=1);

namespace App\Users\Service;


use App\Bids\Model\Bid;
use App\Users\DataTransfer\UserDataTransfer;
use App\Users\Model\User;

/**
 * Interface UsersServiceInterface
 * @package App\Users\Service
 */
interface UsersServiceInterface
{
    /**
     * @param string $email
     * @param string $password
     * @return User
     */
    public function signup(string $email, string $password): User;

    /**
     * @param string $email
     * @param string $password
     * @param array $prevs
     * @return User
     */
    public function create(string $email, string $password, array $prevs): User;

    /**
     * @param Bid $bid
     * @return User
     */
//    public function createFromBid(Bid $bid): User;

    /**
     * @param int $id
     * @param UserDataTransfer $dataTransfer
     * @return User
     */
    public function edit(int $id, UserDataTransfer $dataTransfer): User;

    /**
     * @param array $order
     * @param int $limit
     * @param int $offset
     * @return User[]
     */
    public function list(array $order, int $limit, int $offset): array;

    /**
     * @param int $id
     * @return User
     */
    public function one(int $id): User;
}