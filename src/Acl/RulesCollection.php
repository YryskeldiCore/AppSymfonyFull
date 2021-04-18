<?php
declare(strict_types=1);

namespace App\Acl;


use App\Acl\Exception\RuleMatchException;

/**
 * TODO: make methods:
 * @method remove
 */

/**
 * Class RulesCollection
 * @package App\Acl
 */
class RulesCollection
{
    /**
     * @var array
     */
    private $rules = [];

    /**
     * @param RuleInterface $rule
     */
    public function register(RuleInterface $rule): void
    {
        $key = "{$rule->getController()}@{$rule->getAction()}";

        $this->rules[$key] = $rule;
    }

    /**
     * @param string $key
     * @return bool
     */
    public function has(string $key): bool
    {
        return $this->rules[$key] ?? false;
    }

    /**
     * @param string $key
     * @return Rule|null
     */
    public function get(string $key): ?Rule
    {
        return $this->rules[$key] ?? null;
    }

    /**
     * @param string $controller
     * @param string $action
     * @return Rule
     */
    public function match(string $controller, string $action): Rule
    {
        $key = "{$controller}@{$action}";

        if(!$rule = $this->get($key)){
            throw new RuleMatchException("Rule not found for {$key}");
        }

        return $rule;
    }


}