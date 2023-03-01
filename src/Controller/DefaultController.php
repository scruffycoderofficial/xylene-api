<?php

declare(strict_types=1);

namespace Xylene\Controller;

use Symfony\Component\HttpFoundation\Response;

/**
 * Class DefaultController
 *
 * @package Xylene\Controller
 * @author Siko Luyanda <sikoluyanda@gmail.com>
 */
class DefaultController extends AbstractController
{
    /**
     * @return Response
     */
    public function defaultAction(): Response
    {
        $name = $this->request->get('name');

        return new Response("Hello $name");
    }
}