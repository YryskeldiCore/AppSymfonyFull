<?php
declare(strict_types=1);

namespace App\Acl;


interface RuleInterface
{
    public function getController(): string;

    public function getAction(): string;

    public function getErrorMessage(): string;

    public function getPrivilege(): string;
}