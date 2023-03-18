<?php

declare(strict_types=1);

namespace Xylene\Controller;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Xylene\Entity\Page;

/**
 * Class PageController.
 *
 * @author Siko Luyanda <sikoluyanda@gmail.com>
 */
class PageController
{
    /** @var Twig_Environment */
    protected $templating;

    /** @var EntityRepository */
    protected $pageRepository;

    public function __construct($templating, $pageRepository)
    {
        $this->templating = $templating;
        $this->pageRepository = $pageRepository;
    }

    public function defaultAction($id): Response
    {
        /** @var Page $page */
        $page = $this->pageRepository->find($id);
        if (!$page) {
            throw new NotFoundHttpException();
        }

        $content = $this->templating->render(
            'Page\default.twig',
            [
                'title' => $page->getTitle(),
                'content' => $page->getContent(),
            ]
        );

        return new Response($content);
    }
}
