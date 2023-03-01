<?php

declare(strict_types=1);

namespace Xylene\Controller;

use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Routing\Generator\UrlGenerator;

/**
 * Class WebController
 *
 * @package Xylene\Controller
 * @author Siko Luyanda <sikoluyanda@gmail.com>s
 */
abstract class AbstractController
{
    /** @var Request */
    protected $request;

    /** @var EntityManager */
    protected $entityManager;

    /** @var UrlGenerator */
    protected $urlGenerator;

    function __construct(
        Request $request,
        EntityManager $entityManager,
        UrlGenerator $urlGenerator
    ) {
        $this->request = $request;
        $this->entityManager = $entityManager;
        $this->urlGenerator = $urlGenerator;
    }
}