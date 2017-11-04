<?php
declare(strict_types=1);

namespace Darrigo\MovieCatalog\Application\Provider;

use Darrigo\MovieCatalog\Application\Controller\MovieController;
use Darrigo\MovieCatalog\Application\FrontController;
use Darrigo\MovieCatalog\Container\ContainerInterface;
use Darrigo\MovieCatalog\Shared\ProviderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouteCollection;

/**
 * Class ApplicationProvider
 * @package Darrigo\MovieCatalog\Application\Provider
 */
class ApplicationProvider implements ProviderInterface
{
    /**
     * @param ContainerInterface $container
     */
    private function registerControllers(ContainerInterface $container): void
    {
        $container->set('application.controllers.movie', new MovieController());
    }

    /**
     * @param ContainerInterface $container
     */
    public function register(ContainerInterface $container): void
    {
        $container->set('application.routes', new RouteCollection());

        $container->set('application.request', Request::createFromGlobals());

        $container->set('application.request.context', function (Request $request) {
            $context = new RequestContext();
            return $context->fromRequest($request);
        });

        $container->set('application.url.matcher', function() use ($container) {
            $request = $container->get('application.request');
            return new UrlMatcher(
                $container->get('application.routes'),
                $container->get('application.request.context')->call($container, $request)
            );
        });

        $container->set('application.front.controller', new FrontController(
            $container->get('application.url.matcher')->call($container)
        ));
    }
}