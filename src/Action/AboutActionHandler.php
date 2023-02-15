<?php

declare(strict_types=1);

namespace Xylene\Action;

use Psr\Container\NotFoundExceptionInterface;
use Psr\Container\ContainerExceptionInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Xylene\EventSubscriber\Parameter\RequiredRequestParameterException;

/**
 * Class AboutActionHandler
 * s
 * @package Xylene\Action
 */
class AboutActionHandler extends ActionHandler
{
    /**
     * API Metadata
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        try {

            return $this->json([
                'message' => 'About Xylene Framework',
                'data' => [
                    'version' => '0.0.1',
                    'developer(s)' => 'Siko Luyanda & ' . $this->resolveRequiredParameter('developer', $request)
                ]
            ], Response::HTTP_CREATED);

        } catch (NotFoundExceptionInterface | ContainerExceptionInterface | RequiredRequestParameterException $e) {
        }
    }

    public function registerEvents($vents = []): void
    {
        // TODO: Implement registerEvents() method.
    }
}