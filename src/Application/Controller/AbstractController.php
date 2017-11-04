<?php
declare(strict_types=1);

namespace Darrigo\MovieCatalog\Application\Controller;

use Darrigo\MovieCatalog\Application\Service\MovieCatalogInterface;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Response;

abstract class AbstractController
{
    /**
     * @var MovieCatalogInterface $movieCatalog
     */
    protected $movieCatalog;

    /**
     * @var SerializerInterface $serializer
     */
    protected $serializer;

    /**
     * AbstractController constructor.
     * @param MovieCatalogInterface $movieCatalog
     * @param SerializerInterface $serializer
     */
    public function __construct(MovieCatalogInterface $movieCatalog, SerializerInterface $serializer)
    {
        $this->movieCatalog = $movieCatalog;
        $this->serializer = $serializer;
    }

    /**
     * @param $data
     * @param int $statusCode
     * @return Response
     */
    public function jsonResponse($data, int $statusCode): Response
    {
        return new Response($this->serializer->serialize($data, 'json'), $statusCode, [
            'Content-Type' => 'application/json'
        ]);
    }
}
