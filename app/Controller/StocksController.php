<?php

declare(strict_types=1);

namespace OffCut\RestfulApi\Controller;

use OffCut\RestfulApi\Core\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class StocksController
 *
 * @author Siko Luyanda <sikoluyanda@gmail.com>
 */
class StocksController extends AbstractController
{
    /**
     * @return JsonResponse
     */
    public function indexAction(): JsonResponse
    {
        return new JsonResponse([$this->container->has('dump_var')]);
    }
}