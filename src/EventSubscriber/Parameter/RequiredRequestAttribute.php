<?php

declare(strict_types=1);

namespace Xylene\EventSubscriber\Parameter;

use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class RequiredRequestAttribute
 *
 * @package Xylene\EventSubscriber
 */
class RequiredRequestAttribute implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => 'onKernelException',
        ];
    }

    public function onKernelException(ExceptionEvent $event)
    {
        $exception = $event->getThrowable();
        if ($exception instanceof RequiredRequestParameterException) {
            $event->setResponse(new JsonResponse([
                'message' => $exception->getMessage(),
            ], Response::HTTP_BAD_REQUEST));
        }

        return $exception;
    }
}