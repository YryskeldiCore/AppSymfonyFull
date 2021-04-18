<?php
declare(strict_types=1);

namespace App\Users\Model;

use Doctrine\ORM\Mapping as ORM;
use ReflectionClass;


/**
 * Class Privileges
 * @package App\Users\Model
 * @ORM\Entity()
 */
class Privileges
{
    const ENABLE = true;
    const DISABLE = false;

    /**
     * @var int
     * @ORM\Id();
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer", length=11)
     */
    private $id;

    /**
     * @ORM\Column(type="boolean")
     * @var bool
     */
    private $bidList = false;

    /**
     * @ORM\Column(type="boolean")
     * @var bool
     */
    private $bidGetWaiting = false;

    /**
     * @ORM\Column(type="boolean")
     * @var bool
     */
    private $bidGetAccepted = false;

    /**
     * @ORM\Column(type="boolean")
     * @var bool
     */
    private $bidGetCalled = false;

    /**
     * @ORM\Column(type="boolean")
     * @var bool
     */
    private $bidGetRejected = false;

    /**
     * @ORM\Column(type="boolean")
     * @var bool
     */
    private $bidGetConfirmed = false;

    /**
     * @ORM\Column(type="boolean")
     * @var bool
     */
    private $bidGetPostponed = false;

    /**
     * @ORM\Column(type="boolean")
     * @var bool
     */
    private $bidCreate = false;

    /**
     * @ORM\Column(type="boolean")
     * @var bool
     */
    private $bidCall = false;

    /**
     * @ORM\Column(type="boolean")
     * @var bool
     */
    private $bidAccept = false;

    /**
     * @ORM\Column(type="boolean")
     * @var bool
     */
    private $bidReject = false;

    /**
     * @ORM\Column(type="boolean")
     * @var bool
     */
    private $bidPostponed = false;

    /**
     * @ORM\Column(type="boolean")
     * @var bool
     */
    private $bidConfirm = false;

    public static function createFree(): self
    {
        $prev = new self();


        return $prev;
    }

    public function fromArray(array $prevs): void
    {
        foreach ($prevs as $prop => $prev){
            $this->changePrivileges($prop, $prev);
        }

        return;
    }

    public function toArray(): array
    {
        $list = [];

        $refl = new \ReflectionObject($this);

        $props = $refl->getProperties();

        foreach ($props as $prop){
            if($prop->getName() == 'id') continue;
            $prop->setAccessible(true);
            $list[$prop->getName()] = $prop->getValue($this);
        }

        return $list;
    }


    /**
     * @return array
     */
    public static function privilegesList(): array
    {
        try{
            $list = [];

            $refl = new ReflectionClass(self::class);

            $props = $refl->getProperties();

            foreach ($props as $prop){
                if($prop->getName() == 'id') continue;
                $list[] = $prop->getName();
            }

        }catch (\ReflectionException $e){

        }finally{
            return $list;
        }
    }

    public function changePrivileges(string $prop, bool $state): void
    {
        if(property_exists($this, $prop)) {
            $this->$prop = $state;
        }

        return;
    }

    public function can(string $prop): bool
    {
        if(!property_exists($this, $prop)){
            throw new \InvalidArgumentException("Привилегия ошибочна");
        }

        return $this->{$prop};
    }

    /**
     * @return bool
     */
    public function isBidList(): bool
    {
        return $this->bidList;
    }

    /**
     * @return bool
     */
    public function isBidGetWaiting(): bool
    {
        return $this->bidGetWaiting;
    }

    /**
     * @return bool
     */
    public function isBidGetAccepted(): bool
    {
        return $this->bidGetAccepted;
    }

    /**
     * @return bool
     */
    public function isBidGetCalled(): bool
    {
        return $this->bidGetCalled;
    }

    /**
     * @return bool
     */
    public function isBidGetRejected(): bool
    {
        return $this->bidGetRejected;
    }

    /**
     * @return bool
     */
    public function isBidGetConfirmed(): bool
    {
        return $this->bidGetConfirmed;
    }

    /**
     * @return bool
     */
    public function isBidGetPostponed(): bool
    {
        return $this->bidGetPostponed;
    }

    /**
     * @return bool
     */
    public function isBidCreate(): bool
    {
        return $this->bidCreate;
    }

    /**
     * @return bool
     */
    public function isBidCall(): bool
    {
        return $this->bidCall;
    }

    /**
     * @return bool
     */
    public function isBidAccept(): bool
    {
        return $this->bidAccept;
    }

    /**
     * @return bool
     */
    public function isBidReject(): bool
    {
        return $this->bidReject;
    }

    /**
     * @return bool
     */
    public function isBidPostponed(): bool
    {
        return $this->bidPostponed;
    }

    /**
     * @return bool
     */
    public function isBidConfirm(): bool
    {
        return $this->bidConfirm;
    }


}