<?php

declare(strict_types=1);

namespace OffCut\RestfulApi\Core;

use OffCut\RestfulApi\Core\Event\RequestEvent;
use Symfony\Contracts\EventDispatcher\Event;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

/**
 * Class App
 *
 * @package OffCut\RestfulApi\Core
 */
final class App implements HttpKernelInterface
{
    /**
     * @var array App routes
     */
    protected $routes = array();

    /**
     * @var EventDispatcher $dispatcher
     */
    protected $dispatcher;

    public function __construct()
    {
        $this->routes = new RouteCollection();

        $this->dispatcher = new EventDispatcher();
    }

    /**
     * @param Request $request
     * @param int $type
     * @param bool $catch
     * @return Response
     */
    public function handle(Request $request, int $type = self::MAIN_REQUEST, bool $catch = true): Response
    {
        $context = new RequestContext();

        $context->fromRequest($request);

        $matcher = new UrlMatcher($this->routes, $context);

        try {

            $attributes = $matcher->match($request->getPathInfo());
            $controller = $attributes['controller'];

            unset($attributes['controller']);

            $event = new RequestEvent($this, $request, App::MAIN_REQUEST);

            $event->setRequest($request);

            $this->fire($event);

            $response = call_user_func_array($controller, array_values($attributes));

        } catch (ResourceNotFoundException $e) {
            $response = new Response('Not found!', Response::HTTP_NOT_FOUND);
        }

        return $response;
    }

    /**
     * Associates a given URL with a callback function
     *
     * @param $path
     * @param $controller
     */
    public function map($path, $controller) {
        $this->routes->add($path, new Route($path, ['controller' => $controller]));
    }

    /**
     * @param $event
     * @param $callback
     */
    public function on($event, $callback)
    {
        $this->dispatcher->addListener($event, $callback);
    }

    /**
     * @param $event
     * @return Event
     */
    public function fire($event): Event
    {
        return $this->dispatcher->dispatch($event);
    }
}