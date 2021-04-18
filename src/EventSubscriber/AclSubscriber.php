<?php
declare(strict_types=1);

namespace App\EventSubscriber;


use App\Acl\AclPrivileges;
use App\Acl\Rule;
use App\Acl\RulesCollection;
use App\Auth\AccessTokenInterface;
use App\Controller\API\Bids\BidController;
use App\Controller\API\Users\AuthController;
use App\Controller\API\Users\UsersController;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\KernelInterface;

class AclSubscriber implements EventSubscriberInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @var RulesCollection
     */
    private $rules;


    /**
     * Returns an array of event names this subscriber wants to listen to.
     *
     * The array keys are event names and the value can be:
     *
     *  * The method name to call (priority defaults to 0)
     *  * An array composed of the method name to call and the priority
     *  * An array of arrays composed of the method names to call and respective
     *    priorities, or 0 if unset
     *
     * For instance:
     *
     *  * ['eventName' => 'methodName']
     *  * ['eventName' => ['methodName', $priority]]
     *  * ['eventName' => [['methodName1', $priority], ['methodName2']]]
     *
     * @return array The event names to listen to
     */
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::CONTROLLER => [
                ['initializeRules', 2],
                ['check', 1]
            ]
        ];
    }

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function initializeRules(){
        $this->rules = new RulesCollection();

        ### FOR ALL

        $this->rules->register(new Rule(AuthController::class, "login", AclPrivileges::ALL));

        $this->rules->register(new Rule(UsersController::class, "one", AclPrivileges::ALL));
        $this->rules->register(new Rule(UsersController::class, "list", AclPrivileges::ALL));

        $this->rules->register(new Rule(BidController::class, "create", AclPrivileges::ALL));

        ### FOR GUEST


        ### CUSTOM RULES

        $this->rules->register(new Rule(BidController::class, 'list', 'bidList'));
        $this->rules->register(new Rule(BidController::class, "getWaiting", "bidGetWaiting"));
        $this->rules->register(new Rule(BidController::class, "getAccepted", "bidGetAccepted"));
        $this->rules->register(new Rule(BidController::class, "getCalled", "bidGetCalled"));
        $this->rules->register(new Rule(BidController::class, "getRejected", "bidGetRejected"));
        $this->rules->register(new Rule(BidController::class, "getConfirmed", "bidGetConfirmed"));
        $this->rules->register(new Rule(BidController::class, "confirm", "bidConfirm"));
        $this->rules->register(new Rule(BidController::class, "call", "bidCall"));
        $this->rules->register(new Rule(BidController::class, "accept", "bidAccept"));
        $this->rules->register(new Rule(BidController::class, "reject", "bidReject"));
        $this->rules->register(new Rule(BidController::class, "postponed", "bidPostponed"));
    }


    public function check(FilterControllerEvent $event): void
    {

        $request = $event->getRequest();

        if($request->headers->has('authorization')){
            /** @var AccessTokenInterface $token */
            $token = $this->container->get(AccessTokenInterface::class);
        }else{
            $token = null;
        }


        $acl = new AclPrivileges($token, $this->rules);

        list($controller, $action) = [get_class($event->getController()[0]), $event->getController()[1]];

        $resource = "{$controller}@{$action}";

        $acl->isAllowed($resource);

        return;
    }
}