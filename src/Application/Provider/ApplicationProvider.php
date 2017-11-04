<?php
declare(strict_types=1);

namespace Darrigo\MovieCatalog\Application\Provider;

use Darrigo\MovieCatalog\Application\Controller\MovieController;
use Darrigo\MovieCatalog\Application\FrontController;
use Darrigo\MovieCatalog\Application\Service\MovieCatalog;
use Darrigo\MovieCatalog\Container\ContainerInterface;
use Darrigo\MovieCatalog\Shared\ProviderInterface;
use JMS\Serializer\SerializerBuilder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Route;
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
    public function register(ContainerInterface $container): void
    {
        $container->set('application.routes', new RouteCollection());

        $container->set('application.request', Request::createFromGlobals());

        $container->set('application.request.context', function (Request $request) {
            $context = new RequestContext();
            return $context->fromRequest($request);
        });

        $container->set('application.url.matcher', function () use ($container) {
            $request = $container->get('application.request');
            return new UrlMatcher(
                $container->get('application.routes'),
                $container->get('application.request.context')->call($container, $request)
            );
        });

        $container->set('application.front.controller', new FrontController(
            $container->get('application.url.matcher')->call($container)
        ));

        $container->set('application.serializer', (new SerializerBuilder())->build());

        $this->registerServices($container);
        $this->registerControllers($container);
        $this->registerRoutes($container);
    }

    /**
     * @param ContainerInterface $container
     */
    private function registerServices(ContainerInterface $container): void
    {
        $container->set('application.service.movie.catalog', new MovieCatalog(
            $container->get('domain.repository.movies'),
            $container->get('domain.repository.genres')
        ));
    }

    /**
     * @param ContainerInterface $container
     */
    private function registerControllers(ContainerInterface $container): void
    {
        $container->set('application.controller.movie', new MovieController(
            $container->get('application.service.movie.catalog'),
            $container->get('application.serializer')
        ));
    }

    /**
     * @param ContainerInterface $container
     */
    private function registerRoutes(ContainerInterface $container): void
    {
        /** @var RouteCollection $routes */
        $routes = $container->get('application.routes');

        $routes->add('movies.get', (new Route('/movies', [
            '_controller' => [
                $container->get('application.controller.movie'), 'getAll'
            ]
        ]))->setMethods('GET'));

        $routes->add('movies.get.id', (new Route('/movies/{id}', [
            '_controller' => [
                $container->get('application.controller.movie'), 'get'
            ]
        ]))->setMethods('GET'));
    }
}