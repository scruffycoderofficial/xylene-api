<?php

declare(strict_types=1);

namespace Xylene\Foundation;

use Exception;
use Throwable;
use Xylene\Action\ActionResolver;
use Symfony\Component\Routing\Route;
use Psr\Container\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Xylene\Provider\Contract\ServiceProviderInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Xylene\Provider\Contract\BootableProviderInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\Event\FinishRequestEvent;
use Xylene\Provider\Contract\EventListenerProviderInterface;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver;
use Symfony\Component\HttpKernel\Event\ControllerArgumentsEvent;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Controller\ArgumentResolverInterface;
use Symfony\Component\HttpFoundation\Exception\RequestExceptionInterface;
use Symfony\Component\HttpKernel\Exception\ControllerDoesNotReturnResponseException;

/**
 * Class Application
 *
 * @package Xylene\Foundation
 * @author Luyanda Siko <sikoluyanda@gmail.com>
 */
final class Application implements HttpKernelInterface
{
    /**
     * The version of this Application, to be
     * updated with each release
     */
    const VERSION = '0.0.1';

    /**
     * @var array App routes
     */
    private $routes = array();

    /**s
     * @var EventDispatcher $dispatcher
     */
    private $dispatcher;

    /**
     * @var $actionResolver
     */
    private $actionResolver;

    /**
     * @var $requestStack
     */
    private $requestStack = null;

    /**
     * @var $argumentResolver
     */
    private $argumentResolver = null;

    /**
     * @var array $providers
     */
    private $providers = [];

    /**
     * @var $booted
     */
    protected $booted = false;

    /**
     * @var $container
     */
    protected $container = null;

    /**
     * App constructor.
     *
     * @param RouteCollection $routes
     * @param EventDispatcher $events
     * @param ActionResolver $actionResolver
     * @param RequestStack|null $requestStack
     * @param ArgumentResolverInterface|null $argumentResolver
     */
    public function __construct(RouteCollection $routes, EventDispatcher $events, ActionResolver $actionResolver, RequestStack $requestStack = null, ArgumentResolverInterface $argumentResolver = null)
    {
        $this->routes = $routes;
        $this->dispatcher = $events;
        $this->actionResolver = $actionResolver;
        $this->requestStack = $requestStack ?? new RequestStack();
        $this->argumentResolver = $argumentResolver ?? new ArgumentResolver();
    }

    public function isBooted(): bool
    {
        return $this->booted;
    }

    /**
     * {@inheritdoc}
     *
     * @param Request $request
     * @param int $type
     * @param bool $catch
     * @return Response
     * @throws Exception
     * @throws Throwable
     */
    public function handle(Request $request, int $type = HttpKernelInterface::MAIN_REQUEST, bool $catch = true): Response
    {
        $request->headers->set('X-Php-Ob-Level', (string) ob_get_level());

        $this->requestStack->push($request);

        try {

            if (!$this->booted) {
                $this->boot();
            }

            return $this->handleRaw($request, $this->getUrlMatcher($request), $type);

        } catch (Exception $e) {

            if ($e instanceof RequestExceptionInterface) {
                $e = new BadRequestHttpException($e->getMessage(), $e);
            }

            if (false === $catch) {

                $this->finishRequest($request, $type);

                throw $e;
            }

            return $this->handleThrowable($e, $request, $type);

        } finally {

            $this->requestStack->pop();
        }
    }

    /**
     * @param $path
     * @param $controller
     */
    public function map($path, $controller)
    {
        $this->routes->add($path, new Route($path, ['_controller' => $controller]));
    }

    /**
     * Registers a service provider.
     *
     * @param ServiceProviderInterface $provider A ServiceProviderInterface instance
     * @param array                    $values   An array of values that customizes the provider
     *
     * @return Application
     */
    public function register(ServiceProviderInterface $provider, array $values = []): self
    {
        $this->providers[] = $provider;

        return $this;
    }

    public function boot()
    {
        if ($this->booted) {
            return;
        }

        $this->booted = true;

        foreach ($this->providers as $provider) {

            $provider->register($this->container);

            if ($provider instanceof EventListenerProviderInterface) {

                $provider->subscribe($this, $this->dispatcher);
            }

            if ($provider instanceof BootableProviderInterface) {

                $provider->boot($this);
            }
        }
    }

    /**
     * @param $container
     * @return $this
     */
    public function setContainer(ContainerInterface $container = null): self
    {
        $this->container = $container;

        return $this;
    }

    /**
     * @return ContainerInterface
     */
    public function getContainer(): ContainerInterface
    {
        return $this->container;
    }

    /**
     * @param $request
     * @return UrlMatcher
     */
    private function getUrlMatcher($request): UrlMatcher
    {
        return new UrlMatcher($this->routes, $this->getRequestContext($request));
    }

    /**
     * @param $request
     * @return RequestContext
     */
    private function getRequestContext($request): RequestContext
    {
        $context = new RequestContext();

        $context->fromRequest($request);

        return $context;
    }

    /**
     * @param $request
     * @param $matcher
     * @param $type
     * @return Response
     */
    private function handleRaw($request, $matcher, $type): Response
    {
        $requestEvent = new RequestEvent($this, $request, $type);

        $this->dispatcher->dispatch($requestEvent, KernelEvents::REQUEST);

        if ($requestEvent->hasResponse()) {

            return $this->filterResponse($requestEvent->getResponse(), $request, $type);
        }

        $request->attributes->add($matcher->match($request->getPathInfo()));

        if (false === $controller = $this->actionResolver->getController($request)) {

            throw new NotFoundHttpException(sprintf('Unable to find the controller for path "%s". The route is wrongly configured.', $request->getPathInfo()));
        }

        $controllerEvent = new ControllerEvent($this, $controller, $request, $type);
        $this->dispatcher->dispatch($controllerEvent, KernelEvents::CONTROLLER);

        $controller = $controllerEvent->getController();
        $arguments = $this->argumentResolver->getArguments($request, $controller);

        $controllerArgumentsEvent = new ControllerArgumentsEvent($this, $controller, $arguments, $request, $type);

        $this->dispatcher->dispatch($controllerArgumentsEvent, KernelEvents::CONTROLLER_ARGUMENTS);

        $controller = $controllerArgumentsEvent->getController();
        $arguments = $controllerArgumentsEvent->getArguments();

        $response = call_user_func_array($controller, $arguments);

        if (!$response instanceof Response) {

            if ($event->hasResponse()) {

                $response = $event->getResponse();
            } else {

                $msg = sprintf('The controller must return a "Symfony\Component\HttpFoundation\Response" object but it returned %s.', $this->varToString($response));

                if (null === $response) {
                    $msg .= ' Did you forget to add a return statement somewhere in your controller?';
                }

                throw new ControllerDoesNotReturnResponseException($msg, $controller, __FILE__, __LINE__ - 17);
            }
        }

        return $this->filterResponse($response, $request, $type);
    }

    /**
     * Filters a response object.
     *
     * @param Response $response
     * @param Request $request
     * @param int $type
     * @return Response
     */
    private function filterResponse(Response $response, Request $request, int $type): Response
    {
        $responseEvent = new ResponseEvent($this, $request, $type, $response);

        $this->dispatcher->dispatch($responseEvent, KernelEvents::RESPONSE);

        $this->finishRequest($request, $type);

        return $responseEvent->getResponse();
    }

    /**
     * Publishes the finish request event, then pop the request from the stack.
     *
     * Note that the order of the operations is important here, otherwise
     * operations such as {@link RequestStack::getParentRequest()} can lead to
     * weird results.
     * @param Request $request
     * @param int $type
     */
    private function finishRequest(Request $request, int $type)
    {
        $this->dispatcher->dispatch(new FinishRequestEvent($this, $request, $type), KernelEvents::FINISH_REQUEST);
    }

    /**
     * Handles a throwable by trying to convert it to a Response.
     *
     * @param Throwable $e
     * @param Request $request
     * @param int $type
     * @return Response
     * @throws Throwable
     */
    private function handleThrowable(Throwable $e, Request $request, int $type): Response
    {
        $exceptionEvent = new ExceptionEvent($this, $request, $type, $e);

        $this->dispatcher->dispatch($exceptionEvent, KernelEvents::EXCEPTION);

        $e = $exceptionEvent->getThrowable();

        if (!$exceptionEvent->hasResponse()) {

            $this->finishRequest($request, $type);

            throw $e;
        }

        $response = $exceptionEvent->getResponse();

        if (!$exceptionEvent->isAllowingCustomResponseCode() && !$response->isClientError() && !$response->isServerError() && !$response->isRedirect()) {

            if ($e instanceof HttpExceptionInterface) {

                $response->setStatusCode($e->getStatusCode());
                $response->headers->add($e->getHeaders());

            } else {

                $response->setStatusCode(500);
            }
        }

        try {

            return $this->filterResponse($response, $request, $type);

        } catch (Exception $e) {

            return $response;
        }
    }
}