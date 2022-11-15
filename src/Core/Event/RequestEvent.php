<?php

namespace OffCut\RestfulApi\Core\Event;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\RequestEvent as BaseRequestEvent;

/**
 * Class RequestEvent
 *
 * @package OffCut\RestfulApi\Core\Event
 */
final class RequestEvent extends BaseRequestEvent
{
    /**
     * @var Request $request
     */
    protected $request;

    /**
     * @param Request $request
     */
    public function setRequest(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @return Request
     */
    public function getRequest(): Request
    {
        return $this->request;
    }
}