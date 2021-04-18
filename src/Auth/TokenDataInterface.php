<?php
declare(strict_types=1);

namespace App\Auth;


interface TokenDataInterface extends \Serializable
{
    public function getId(): int;

    public function getPrivileges(): array;
}