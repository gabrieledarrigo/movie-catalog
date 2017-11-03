<?php
declare(strict_types=1);

namespace Tests\Darrigo\MovieCatalog\Application;

use Darrigo\MovieCatalog\Application\FrontController;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

/**
 * Class FrontControllerTest
 * @author darrigo.g@gmail.com
 */
final class FrontControllerTest extends TestCase
{
    /**
     * @var RouteCollection
     */
    private $routes;

    /**
     * @var UrlMatcher|\PHPUnit_Framework_MockObject_MockObject
     */
    private $urlMatcher;

    protected function setUp(): void
    {
        parent::setUp();
        $this->routes = new RouteCollection();
        $this->urlMatcher = $this->getMockBuilder(UrlMatcher::class)
            ->disableOriginalConstructor()
            ->getMock();
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        $this->routes = null;
    }

    public function testItShouldAssignTheHTTRequestToTheRightHandler(): void
    {
        $controller = $this->getMockBuilder(\stdClass::class)
            ->setMethods(['__invoke'])
            ->getMock();

        $attributes = ['_controller' => $controller];
        $request = Request::create('/foo');

        $this->routes->add('foo.get', new Route('/foo', $attributes));

        $this->urlMatcher->expects($this->once())
            ->method('match')
            ->with('/foo')
            ->willReturn($attributes);

        $controller->expects($this->once())
            ->method('__invoke')
            ->with($request)
            ->willReturn(new Response('ok'));

        $frontController = new FrontController($this->urlMatcher);
        $response = $frontController->handle($request);
        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals('ok', $response->getContent());
    }

    public function testItShouldReturnANotFoundResponseIfNotHandlerCanBeFound()
    {
        $this->routes->add('foo.get', new Route('/foo', []));

        $this->urlMatcher->expects($this->once())
            ->method('match')
            ->with('/foo')
            ->willThrowException(new ResourceNotFoundException('Not found'));

        $frontController = new FrontController($this->urlMatcher);
        $response = $frontController->handle(Request::create('/foo'));

        $this->assertEquals(Response::HTTP_NOT_FOUND, $response->getStatusCode());
    }
}