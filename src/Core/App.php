<?php

declare(strict_types=1);

namespace OffCut\RestfulApi\Core;

use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

/**
 * Class App
 *
 * @author Siko Luyanda <sikoluyanda@gmail.com>
 */
final class App implements HttpKernelInterface
{
    const VERSION = '0.0.1';

    /**
     * @var array App routes
     */
    protected $routes = array();

    /**s
     * @var EventDispatcher $dispatcher
     */
    protected $dispatcher;

    /**
     * @var array $providers
     */
    protected $providers = [];

    /**
     * App constructor.
     *
     * @param RouteCollection $routes
     * @param EventDispatcher $events
     */
    public function __construct(RouteCollection $routes, EventDispatcher $events)
    {
        $this->routes = $routes;

        $this->dispatcher = $events;
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

        $controllerResolver = new ControllerResolver();
        $argumentResolver = new ArgumentResolver();

        $matcher = new UrlMatcher($this->routes, $context);

        $response = null;

        try {

            $request->attributes->add($matcher->match($request->getPathInfo()));

            $controller = $controllerResolver->getController($request);
            $arguments = $argumentResolver->getArguments($request, $controller);

            $response = call_user_func_array($controller, $arguments);

        } catch (ResourceNotFoundException $e) {
            $response = new Response('Not found!', Response::HTTP_NOT_FOUND);
        } catch (\Exception $e) {
            $response = new Response('An error occurred', Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $response;
    }

    /**
     * @return EventDispatcher
     */
    public function getDispatcher(): EventDispatcher
    {
        return $this->dispatcher;
    }

    /**
     * Associates a given URL with a callback function
     *
     * @param $path
     * @param $controller
     */
    public function map($path, $controller)
    {
        $this->routes->add($path, new Route($path, ['_controller' => $controller]));
    }
}