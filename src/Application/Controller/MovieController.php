<?php
declare(strict_types=1);

namespace Darrigo\MovieCatalog\Application\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class MovieController
 * @package Darrigo\MovieCatalog\Application\Controller
 */
class MovieController extends AbstractController
{
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

        return $this->jsonResponse($movie, Response::HTTP_OK);
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function getAll(Request $request): Response
    {
        $page = $request->get('page');
        $movies = $this->movieCatalog->getMovies((int)$page);

        return $this->jsonResponse($movies->get(), Response::HTTP_OK);
    }
}
