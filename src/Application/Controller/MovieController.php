<?php
declare(strict_types=1);

namespace Darrigo\MovieCatalog\Application\Controller;

use Darrigo\MovieCatalog\Application\Service\MovieCatalogInterface;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class MovieController
 * @package Darrigo\MovieCatalog\Application\Controller
 */
class MovieController
{
    /**
     * @var MovieCatalogInterface $movieCatalog
     */
    private $movieCatalog;

    /**
     * @var SerializerInterface $serializer
     */
    private $serializer;

    /**
     * MovieController constructor.
     * @param MovieCatalogInterface $movieCatalog
     * @param SerializerInterface $serializer
     */
    public function __construct(MovieCatalogInterface $movieCatalog, SerializerInterface $serializer)
    {
        $this->movieCatalog = $movieCatalog;
        $this->serializer = $serializer;
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function get(Request $request): Response
    {
        $id = $request->attributes->get('id');
        $movie = $this->movieCatalog->getMovie((int)$id)->getOrThrow(
            new NotFoundHttpException("Movie with id $id cannot be found")
        );
        $data = $this->serializer->serialize($movie, 'json');

        return new Response($data, Response::HTTP_OK, [
            'Content-Type', 'application/json'
        ]);
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function getAll(Request $request): Response
    {
        $page = $request->get('page');
        $movies = $this->movieCatalog->getMovies((int) $page);
        $data = $this->serializer->serialize($movies->get(), 'json');

        return new Response($data, Response::HTTP_OK, [
            'Content-Type', 'application/json'
        ]);
    }
}
