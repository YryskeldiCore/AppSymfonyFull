<?php
declare(strict_types=1);

namespace App\Acl;


use App\Acl\Exception\AllowedException;
use App\Auth\AccessTokenInterface;


/**
 * TODO: do think about guest :)
 * Class AclPrivileges
 * @package App\Acl
 */
class AclPrivileges implements AclInterface
{

    public const GUEST = 'guest';
    public const ALL = 'all';

    /**
     * @var AccessTokenInterface|null
     */
    private $accessToken;
    /**
     * @var RulesCollection
     */
    private $rules;

    public function __construct(?AccessTokenInterface $accessToken, RulesCollection $rules)
    {
        $this->accessToken = $accessToken;
        $this->rules = $rules;
    }


    /**
     * @throws AllowedException
     * @param string $resource
     * @return bool
     */
    public function isAllowed(string $resource = null): bool
    {
        list($controller, $action) = explode("@", $resource);


        $rule = $this->rules->match($controller, $action);

        if($rule->getPrivilege() === self::ALL){
            return true;
        }

        if($rule->getPrivilege() === self::GUEST){
            if($this->accessToken === null){
                return true;
            }
            throw new AllowedException($rule->getErrorMessage());
        }

        if(!$this->accessToken){
            throw new AllowedException("Недостаточно прав");
        }

        /** @var array $privileges */
        $privileges = $this->accessToken->getData()->getPrivileges();

        if(!$privileges[$rule->getPrivilege()]){
            throw new AllowedException($rule->getErrorMessage());
        }

        return true;
    }
}