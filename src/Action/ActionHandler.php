<?php

declare(strict_types=1);

namespace Xylene\Action;

use Symfony\Component\HttpFoundation\InputBag;
use Symfony\Component\HttpFoundation\Request;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Xylene\EventSubscriber\Parameter\RequiredRequestParameterException;

/**
 * Class ActionHandler
 *
 * @package Xylen\Action
 * @author Luyanda Siko <sikoluyanda@gmail.com>
 */
abstract class ActionHandler
{
    /**
     * @var ContainerInterface $container
     */
    protected $container;

    /**
     * StocksController constructor.
     *
     * @param $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;

        $this->registerEvents();
    }

    /**s
     * @return ContainerInterface
     */
    public function getContainer(): ContainerInterface
    {
        return $this->container;
    }

    /**
     * Returns a JsonResponse that uses the serializer component if enabled, or json_encode.
     * s
     * @param $data
     * @param int $status
     * @param array $headers
     * @param array $context
     * @return JsonResponse
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    protected function json($data, int $status = 200, array $headers = [], array $context = []): JsonResponse
    {
        if ($this->container->has('serializer')) {
            $json = $this->container->get('serializer')->serialize($data, 'json', array_merge([
                'json_encode_options' => JsonResponse::DEFAULT_ENCODING_OPTIONS,
            ], $context));

            return new JsonResponse($json, $status, $headers, true);
        }

        return new JsonResponse($data, $status, $headers);
    }

    /**
     * @param string $parameterName
     * @param Request $request
     * @return bool|float|int|string|InputBag
     * @throws RequiredRequestParameterException
     */
    protected function resolveRequiredParameter(string $parameterName, Request $request): float|InputBag|bool|int|string
    {
        $requiredParameter = $request->request->get($parameterName);
        if (!$requiredParameter) throw new RequiredRequestParameterException("$parameterName is required");
        return $requiredParameter;
    }

    /**
     * @param array $vents
     * @return mixed
     */
    abstract public function registerEvents($vents = []): void;
}