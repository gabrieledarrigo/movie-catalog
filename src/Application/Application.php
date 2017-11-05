<?php
declare(strict_types=1);

namespace Darrigo\MovieCatalog\Application;

use Darrigo\MovieCatalog\Application\Provider\ApplicationProvider;
use Darrigo\MovieCatalog\Container\ContainerInterface;
use Darrigo\MovieCatalog\Domain\Provider\DomainProvider;
use Darrigo\MovieCatalog\Persistence\Provider\StorageProvider;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class Application
 * @package Darrigo\MovieCatalog\Application
 */
class Application
{
    /**
     * @var ContainerInterface $container
     */
    private $container;

    /**
     * Application constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * Register application's provider.
     */
    private function registerProvider(): void
    {
        (new StorageProvider())->register($this->container);
        (new DomainProvider())->register($this->container);
        (new ApplicationProvider())->register($this->container);
    }

    /**
     * @return Response
     */
    public function bootstrap(): Response
    {
        $this->registerProvider();

        /** @var Request $request */
        $request = $this->container->get('application.request');

        /** @var FrontController $frontController */
        $frontController = $this->container->get('application.front.controller');
        return $frontController->handle($request);
    }
}
