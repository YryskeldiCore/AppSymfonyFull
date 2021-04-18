<?php
declare(strict_types=1);

namespace App\Users\Service;


use App\Users\DataTransfer\UserDataTransfer;
use App\Users\Model\User;
use App\Users\Repository\UsersRepositoryInterface;

class UsersService implements UsersServiceInterface
{

    /** @var UsersRepositoryInterface */
    private $repository;


    public function __construct(UsersRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }


    /**
     * @param string $email
     * @param string $password
     * @return User
     */
    public function signup(string $email, string $password): User
    {
        $this->emailIsAvailable($email);

        $user = User::signup($email, $password);

        $this->repository->save($user);

        return $user;
    }

    /**
     * @param string $email
     * @param string $password
     * @param array $prevs
     * @return User
     */
    public function create(string $email, string $password, array $prevs): User
    {
        $this->emailIsAvailable($email);
        $user = User::create($email, $password, $prevs);

        $this->repository->save($user);

        return $user;
    }

    /**
     * @param int $id
     * @param UserDataTransfer $dataTransfer
     * @return User
     */
    public function edit(int $id, UserDataTransfer $dataTransfer): User
    {
        $user = $this->repository->one($id);

        $user->getPrivileges()->fromArray($dataTransfer->privileges);
        $user->changeAge($dataTransfer->age);
        $user->changeEmploy($dataTransfer->employ);
        $user->changeFirstName($dataTransfer->firstName);
        $user->changeLastName($dataTransfer->lastName);
        $user->changeMiddleName($dataTransfer->middleName);
        $user->changePhone($dataTransfer->phone);

        $this->repository->update($user);

        return $user;
    }

    /**
     * @param array $order
     * @param int $limit
     * @param int $offset
     * @return User[]
     */
    public function list(array $order, int $limit, int $offset): array
    {
        return $this->repository->all([], $order, $limit, $offset);
    }

    /**
     * @param int $id
     * @return User
     */
    public function one(int $id): User
    {
        return $this->repository->one($id);
    }


    private function emailIsAvailable(string $email): void
    {
        $user = $this->repository->all(['email' => $email], null, 1);

        if(!empty($user)){
            throw new \LogicException("email занят");
        }

        return;
    }

}