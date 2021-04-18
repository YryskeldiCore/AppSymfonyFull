<?php
declare(strict_types=1);

namespace App\Users\Repository;


use App\Users\Model\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UsersRepository extends ServiceEntityRepository implements UsersRepositoryInterface
{

    private $manager;

    public function __construct(ManagerRegistry $registry, ObjectManager $manager)
    {
        parent::__construct($registry, User::class);
        $this->manager = $manager;
    }

    /**
     * @param array $criteria
     * @param array|null $order
     * @param int|null $limit
     * @param int|null $offset
     * @return array
     */
    public function all(array $criteria = [], array $order = null, int $limit = null, int $offset = null): array
    {
        return parent::findBy($criteria, $order, $limit, $offset);
    }

    /**
     * @param int $id
     * @return User
     */
    public function one(int $id): User
    {
        /** @var User $user */
        $user = parent::findOneBy(['id' => $id]);

        if($user == null){
            throw new NotFoundHttpException("Пользователь не найден");
        }

        return $user;

    }

    /**
     * @param User $user
     * @return User
     */
    public function save(User $user): User
    {
        $this->manager->persist($user);
        $this->manager->flush();

        return $user;
    }

    /**
     * @param User $user
     * @return User
     */
    public function update(User $user): User
    {
        $this->manager->flush();

        return $user;
    }

    public function oneBy(array $criteria): User
    {
        /** @var User $user */
        $user = parent::findOneBy($criteria);

        if($user == null){
            throw new NotFoundHttpException("Пользователь не найден");
        }
        
        return $user;
    }
}