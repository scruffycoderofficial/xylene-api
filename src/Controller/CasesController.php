<?php

declare(strict_types=1);

namespace OffCut\RestfulApi\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class CasesController
 *
 * @package OffCut\RestfulApi\Controller
 */
class CasesController
{
    /**
     * @return JsonResponse
     */
    public function indexAction(): JsonResponse
    {
        return new JsonResponse(['attribute' => 'value',]);
    }
}