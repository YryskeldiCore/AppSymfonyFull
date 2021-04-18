<?php
declare(strict_types=1);

namespace App\EventSubscriber;


use App\Auth\AccessTokenInterface;
use App\Auth\TokenDecoderInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class AuthSubscriber implements EventSubscriberInterface
{

    /**
     * @var TokenDecoderInterface
     */
    private $tokenDecoder;
    /**
     * @var ContainerInterface
     */
    private $container;

    public function __construct(TokenDecoderInterface $tokenDecoder, ContainerInterface $container)
    {
        $this->tokenDecoder = $tokenDecoder;
        $this->container = $container;
    }


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
            KernelEvents::REQUEST => [
                ['authorization', 999],
            ]
        ];
    }

    public function authorization(GetResponseEvent $event): void
    {
        $request = $event->getRequest();

        if(!$token = $request->headers->get('authorization')){
            return;
        }

        $accessToken = $this->tokenDecoder->decode($token);

        $this->container->set(AccessTokenInterface::class, $accessToken);
    }

}