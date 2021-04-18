<?php
declare(strict_types=1);

namespace App\Acl;


use App\Acl\Exception\AllowedException;

interface AclInterface
{
    /**
     * @throws AllowedException
     * @param string $resource
     * @return bool
     */
    public function isAllowed(string $resource = null): bool;
}