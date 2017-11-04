<?php

namespace Tests\Darrigo\MovieCatalog\Application\Controller;

use Darrigo\MovieCatalog\Application\Controller\AbstractController;
use Darrigo\MovieCatalog\Application\Service\MovieCatalogInterface;
use JMS\Serializer\SerializerInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Response;

/**
 * Are you going to test an abstract class?
 * Yes, with the powerful PHP 7 Anonymous classes feature!
 *
 * Class AbstractControllerTest
 * @package Tests\Darrigo\MovieCatalog\Application\Controller
 */
final class AbstractControllerTest extends TestCase
{
    /**
     * @var AbstractController $controller
     */
    private $controller;

    /**
     * @var MovieCatalogInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $movieCatalog;

    /**
     * @var SerializerInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $serializer;

    public function setUp(): void
    {
        parent::setUp();
        $this->movieCatalog = $this->getMockForAbstractClass(MovieCatalogInterface::class);
        $this->serializer = $this->getMockForAbstractClass(SerializerInterface::class);

        $this->controller = new class($this->movieCatalog, $this->serializer) extends AbstractController {
            public function __construct(MovieCatalogInterface $movieCatalog, SerializerInterface $serializer)
            {
                parent::__construct($movieCatalog, $serializer);
            }
        };
    }

    public function testItShouldReturnAJsonResponse(): void
    {
        $data = ['id' => 1];

        $this->serializer->expects($this->once())
            ->method('serialize')
            ->with($data)
            ->willReturn(json_encode($data));

        $response = $this->controller->jsonResponse($data, Response::HTTP_OK);

        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $this->assertEquals('application/json', $response->headers->get('Content-Type'));
        $this->assertEquals(json_encode($data), $response->getContent());
    }
}
