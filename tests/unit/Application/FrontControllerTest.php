<?php
declare(strict_types=1);

namespace Tests\Darrigo\MovieCatalog\Application;

use Darrigo\MovieCatalog\Application\FrontController;
use Darrigo\MovieCatalog\Container\Exception\NotFoundException;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\ServiceUnavailableHttpException;
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

    public function testItShouldAssignTheHTTRequestToTheRightController(): void
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

    public function testItShouldReturnANotFoundResponseIfNoControllerCanBeFound(): void
    {
        $this->routes->add('foo.get', new Route('/foo', []));

        $this->urlMatcher->expects($this->once())
            ->method('match')
            ->with('/foo')
            ->willThrowException(new ResourceNotFoundException('Not found'));

        $frontController = new FrontController($this->urlMatcher);
        $response = $frontController->handle(Request::create('/foo'));

        $this->assertEquals(Response::HTTP_NOT_FOUND, $response->getStatusCode());
        $this->assertEquals(json_encode(['status_code' => Response::HTTP_NOT_FOUND, 'message' => 'Resource not found']), $response->getContent());
    }

    /**
     * @param int $statusCode
     * @param string $message
     * @param HttpException $exception
     * @dataProvider provideHTTPException
     */
    public function testItShouldDirectlyHandleHTTPExceptionThrownByOtherControllers(int $statusCode, string $message, HttpException$exception): void
    {
        $controller = $this->getMockBuilder(\stdClass::class)
            ->setMethods(['__invoke'])
            ->getMock();

        $attributes = ['_controller' => $controller];
        $request = Request::create('/go-wrong');

        $this->routes->add('go.wrong', new Route('/go-wrong', $attributes));

        $this->urlMatcher->expects($this->once())
            ->method('match')
            ->with('/go-wrong')
            ->willReturn($attributes);

        $controller->expects($this->once())
            ->method('__invoke')
            ->with($request)
            ->willThrowException($exception);

        $frontController = new FrontController($this->urlMatcher);
        $response = $frontController->handle($request);

        $this->assertEquals($statusCode, $response->getStatusCode());
        $this->assertEquals(json_encode(['status_code' => $statusCode, 'message' => $message]), $response->getContent());
    }

    /**
     * @return array
     */
    public function provideHTTPException(): array
    {
        return [
            [400, 'Bad Request', new BadRequestHttpException('Bad Request')],
            [404, 'Not Found', new NotFoundHttpException('Not Found')],
            [503, 'Service Unavailable', new ServiceUnavailableHttpException('Service Unavailable', 'Service Unavailable')],
        ];
    }
}