<?php
declare(strict_types=1);

namespace App\EventListener;


use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ExceptionListener
{
    public function onKernelException(GetResponseForExceptionEvent $event): GetResponseForExceptionEvent
    {
        $response = new Response();

        $exception = $event->getException();

        if($exception instanceof \LogicException){
            $exception = new BadRequestHttpException($event->getException()->getMessage());
        }

        if($exception instanceof HttpException){
            /**
             * TODO: fix this
             */
            $response->setStatusCode($exception->getStatusCode());

            $response->setContent(json_encode([
                'error' => $exception->getMessage()
            ]));


            $event->setResponse($response);
        }

        return $event;
    }
}