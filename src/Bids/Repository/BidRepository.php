<?php
declare(strict_types=1);

namespace App\Bids\Repository;


use App\Bids\Model\Bid;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


class BidRepository extends ServiceEntityRepository implements BidRepositoryInterface
{

    private $manager;

    public function __construct(ManagerRegistry $registry, ObjectManager $manager)
    {
        $this->manager = $manager;
        parent::__construct($registry, Bid::class);
    }

    /**
     * @inheritdoc
     * @param array $criteria
     * @param array|null $orderBy
     * @param int $limit
     * @param null $offset
     * @return Bid[]
     */
    public function all(array $criteria = [], array $orderBy = null, $limit = 10, $offset = null): array
    {
        if($orderBy == null){
            $orderBy['id'] = 'DESC';
        }

        /** @var Bid[] $bids */
        $bids = parent::findBy($criteria, $orderBy, $limit, $offset);

        return $bids;
    }

    /**
     * @param $id int
     * @return Bid
     */
    public function one(int $id): Bid
    {
        /**
         * @var Bid $bid
         */
        $bid = parent::findOneBy(['id' => $id]);

        if($bid == null){
            throw new NotFoundHttpException("Заявка {$id} не найденна");
        }

        return $bid;
    }

    /**
     * @param Bid $bid
     * @return Bid
     */
    public function save(Bid $bid): Bid
    {
        $this->manager->persist($bid);
        $this->manager->flush();

        return $bid;
    }

    /**
     * @param Bid $bid
     * @return Bid
     */
    public function update(Bid $bid): Bid
    {
        $this->manager->flush();

        return $bid;
    }
}