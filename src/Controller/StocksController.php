<?php

declare(strict_types=1);

namespace OffCut\RestfulApi\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class StocksController
 *
 * @package OffCut\RestfulApi\Controller
 */
class StocksController
{
    /**
     * @return JsonResponse
     */
    public function indexAction(): JsonResponse
    {
        return new JsonResponse(['attribute' => 'value',]);
    }
}