<?php
declare(strict_types=1);

namespace App\Bids\Service;


use App\Bids\Model\Bid;
use App\Bids\Repository\BidRepositoryInterface;

class BidService implements BidServiceInterface
{
    private $repository;

    public function __construct(BidRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param array $orderBy
     * @param int|null $limit
     * @param int|null $offset
     * @return Bid[]
     */
    public function list(array $orderBy = [], int $limit = null, int $offset = null): array
    {
        return $this->repository->all([], $orderBy, $limit, $offset);
    }


    /**
     * @param string $lastName
     * @param string $firstName
     * @param string $email
     * @param int $age
     * @param string $phone
     * @param string $employ
     * @param string|null $middleName
     * @param string|null $information
     * @return Bid
     */
    public function create(string $lastName, string $firstName, string $email,
                           int $age, string $phone, string $employ,
                           string $middleName = null, string $information = null): Bid
    {
        $bid = new Bid($lastName, $firstName, $email, $age, $phone, $employ);
        $bid->setMiddleName($middleName);
        $bid->setInformation($information);

        $this->repository->save($bid);

        return $bid;
    }


    /**
     * @param int $id
     * @return Bid
     */
    public function call(int $id): Bid
    {
        $bid = $this->repository->one($id);
        $bid->call();

        $this->repository->update($bid);

        return $bid;
    }

    /**
     * @param int $id
     * @return Bid
     */
    public function accept(int $id): Bid
    {
        $bid = $this->repository->one($id);
        $bid->accept();

        $this->repository->update($bid);

        return $bid;
    }

    /**
     * @param int $id
     * @return Bid
     */
    public function reject(int $id): Bid
    {
        $bid = $this->repository->one($id);
        $bid->reject();

        $this->repository->update($bid);

        return $bid;
    }

    /**
     * @param int $id
     * @return Bid
     */
    public function postponed(int $id): Bid
    {
        $bid = $this->repository->one($id);
        $bid->postponed();

        $this->repository->update($bid);

        return $bid;
    }

    /**
     * @param int $id
     * @return Bid
     */
    public function confirm(int $id): Bid
    {
        $bid = $this->repository->one($id);
        $bid->confirm();

        $this->repository->update($bid);

        return $bid;
    }

    /**
     * @param array $orderBy
     * @param int|null $limit
     * @param int|null $offset
     * @return array
     */
    public function getWaiting(array $orderBy = [], int $limit = null, int $offset = null): array
    {
        return $this->repository->all(['status' => Bid::WAIT_CALL], $orderBy, $limit, $offset);
    }

    /**
     * @param array $orderBy
     * @param int|null $limit
     * @param int|null $offset
     * @return Bid[]
     */
    public function getAccepted(array $orderBy = [], int $limit = null, int $offset = null): array
    {
        return $this->repository->all(['status' => Bid::ACCEPTED], $orderBy, $limit, $offset);
    }

    /**
     * @param array $orderBy
     * @param int|null $limit
     * @param int|null $offset
     * @return Bid[]
     */
    public function getRejected(array $orderBy = [], int $limit = null, int $offset = null): array
    {
        return $this->repository->all(['status' => Bid::REJECTED], $orderBy, $limit, $offset);
    }

    /**
     * @param array $orderBy
     * @param int|null $limit
     * @param int|null $offset
     * @return Bid[]
     */
    public function getPostponed(array $orderBy = [], int $limit = null, int $offset = null): array
    {
        return $this->repository->all(['status' => Bid::POSTPONED], $orderBy, $limit, $offset);
    }

    /**
     * @param array $orderBy
     * @param int|null $limit
     * @param int|null $offset
     * @return Bid[]
     */
    public function getCalled(array $orderBy = [], int $limit = null, int $offset = null): array
    {
        return $this->repository->all(['status' => Bid::CALLED], $orderBy, $limit, $offset);
    }

    /**
     * @param array $orderBy
     * @param int|null $limit
     * @param int|null $offset
     * @return Bid[]
     */
    public function getConfirmed(array $orderBy = [], int $limit = null, int $offset = null): array
    {
        return $this->repository->all(['status' => Bid::CONFIRMED], $orderBy, $limit, $offset);
    }


}