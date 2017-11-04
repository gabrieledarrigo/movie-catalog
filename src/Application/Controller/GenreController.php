<?php
declare(strict_types=1);

namespace Darrigo\MovieCatalog\Application\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class GenreController
 * @package Darrigo\MovieCatalog\Application\Controller
 */
class GenreController extends AbstractController
{
    /**
     * @param Request $request
     * @return Response
     */
    public function get(Request $request): Response
    {
        $id = $request->attributes->get('id');
        $movie = $this->movieCatalog->getGenre((int)$id)->getOrThrow(
            new NotFoundHttpException("Genre with id $id cannot be found")
        );

        return $this->jsonResponse($movie, Response::HTTP_OK);
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function getAll(Request $request): Response
    {
        $page = $request->get('page');
        $movies = $this->movieCatalog->getGenres((int)$page);
        $data = $this->serializer->serialize($movies->get(), 'json');

        return new Response($data, Response::HTTP_OK, [
            'Content-Type', 'application/json'
        ]);
    }
}
