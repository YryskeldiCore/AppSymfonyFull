<?php
declare(strict_types=1);

namespace App\Users\Model;

use Doctrine\ORM\Mapping as ORM;


/**
 * Class User
 * @package App\Users\Model
 * @ORM\Entity()
 * @ORM\Table(name="users")
 */
class User
{

    /**
     * @var integer|null
     * @ORM\Column(type="integer", length=11)
     * @ORM\Id()
     * @ORM\GeneratedValue()
     */
    private $id;

    /**
     * @var string|null
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $lastName;

    /**
     * @var string|null
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $firstName;

    /**
     * @var string|null
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $middleName;

    /**
     * @var string|null
     * @ORM\Column(type="integer", length=100, nullable=true)
     */
    private $age;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @var string|null
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $phone;


    /**
     * @var string|null
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $employ;

    /**
     * @var Privileges
     * @ORM\ManyToOne(targetEntity="App\Users\Model\Privileges", cascade={"persist"})
     * @ORM\JoinColumn(name="privileges_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $privileges;

    private function __construct(){}

    public static function signup(string $email, string $password): self
    {
        $user = new self();
        $user->email = $email;
        $user->changePassword($password);

        $prev = Privileges::createFree();
        $user->changePrivileges($prev);

        return $user;
    }

    public static function create(string $email, string $password, array $privileges): self
    {
        $user = new self();
        $user->email = $email;
        $user->changePassword($password);

        $prevs = new Privileges();
        $prevs->fromArray($privileges);

        $user->changePrivileges($prevs);

        return $user;
    }

    public function verifyPassword(string $password): bool
    {
        return password_verify($password, $this->password);
    }

    public function changePrivileges(Privileges $privileges): void
    {
        $this->privileges = $privileges;

        return;
    }


    public function changeEmploy(?string $employ): void
    {
        $this->employ = $employ;

        return;
    }


    public function changeAge(?int $age): void
    {
        $this->age = $age;

        return;
    }

    public function changeFirstName(?string $firstName): void
    {
        $this->firstName = $firstName;

        return;
    }

    public function changeLastName(?string $lastName): void
    {
        $this->lastName = $lastName;

        return;
    }

    public function changeMiddleName(?string $middleName): void
    {
        $this->middleName = $middleName;

        return;
    }

    public function changePhone(?string $phone): void
    {
        $this->phone = $phone;

        return;
    }

    public function changePassword(string $password): void
    {
        $this->password = password_hash($password, PASSWORD_DEFAULT);

        return;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Privileges
     */
    public function getPrivileges(): Privileges
    {
        return $this->privileges;
    }

    /**
     * @return string|null
     */
    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    /**
     * @return string|null
     */
    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    /**
     * @return string|null
     */
    public function getMiddleName(): ?string
    {
        return $this->middleName;
    }

    /**
     * @return string|null
     */
    public function getAge(): ?string
    {
        return $this->age;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string|null
     */
    public function getPhone(): ?string
    {
        return $this->phone;
    }

    /**
     * @return string|null
     */
    public function getEmploy(): ?string
    {
        return $this->employ;
    }

}