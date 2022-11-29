<?php

declare(strict_types=1);

namespace OffCut\RestfulApi\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class ProductsController
 *
 * @package OffCut\RestfulApi\Controller
 */
final class ProductsController
{
    /**
     * @return JsonResponse
     */
    public function indexAction(): JsonResponse
    {
        return new JsonResponse([]);
    }
}