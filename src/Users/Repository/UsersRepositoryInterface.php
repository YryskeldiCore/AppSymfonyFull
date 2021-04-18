<?php
declare(strict_types=1);

namespace App\Users\Repository;


use App\Users\Model\User;

interface UsersRepositoryInterface
{
    /**
     * @param array $criteria
     * @param array|null $order
     * @param int|null $limit
     * @param int|null $offset
     * @return array
     */
    public function all(array $criteria = [], array $order = null, int $limit = null, int $offset = null): array;

    /**
     * @param int $id
     * @return User
     */
    public function one(int $id): User;

    /**
     * @param User $user
     * @return User
     */
    public function save(User $user): User;

    /**
     * @param User $user
     * @return User
     */
    public function update(User $user): User;

    /**
     * @param array $criteria
     * @return User
     */
    public function oneBy(array $criteria): User;
}