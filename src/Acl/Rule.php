<?php
declare(strict_types=1);

namespace App\Acl;


class Rule implements RuleInterface
{


    /**
     * @var string
     */
    private $controller;
    /**
     * @var string
     */
    private $action;
    /**
     * @var string
     */
    private $privilege;
    /**
     * @var string
     */
    private $errorMessage;

    public function __construct(string $controller, string $action,
                                string $privilege, string $errorMessage = "Недостаточно прав")
    {

        $this->controller = $controller;
        $this->action = $action;
        $this->privilege = $privilege;
        $this->errorMessage = $errorMessage;
    }


    public function getController(): string
    {
        return $this->controller;
    }

    public function getAction(): string
    {
        return $this->action;
    }

    public function getErrorMessage(): string
    {
        return $this->errorMessage;
    }

    public function getPrivilege(): string
    {
        return $this->privilege;
    }
}