<?php
declare(strict_types=1);

namespace Darrigo\MovieCatalog\Application;

use Darrigo\MovieCatalog\Application\Value\HttpMessage;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\Matcher\UrlMatcher;

/**
 * Class FrontController
 * @package Darrigo\MovieCatalog\Application
 */
final class FrontController implements HttpKernelInterface
{
    /**
     * @var UrlMatcher
     */
    private $urlMatcher;

    /**
     * FrontController constructor.
     * @param UrlMatcher $urlMatcher
     */
    public function __construct(UrlMatcher $urlMatcher)
    {
        $this->urlMatcher = $urlMatcher;
    }

    /**
     * @param Request $request
     * @param int $type
     * @param bool $catch
     * @return Response
     */
    public function handle(Request $request, $type = self::MASTER_REQUEST, $catch = true): Response
    {
        try {
            $match = $this->urlMatcher->match($request->getPathInfo());
            $request->attributes->add($match);

            return call_user_func_array($match['_controller'], [$request]);
        } catch (HttpException $e) {
            return new Response(
                new HttpMessage((int)$e->getStatusCode(), $e->getMessage()),
                $e->getStatusCode(),
                [
                    'Content-type' => 'application/json'
                ]
            );
        } catch (ResourceNotFoundException $e) {
            return new Response(
                new HttpMessage(Response::HTTP_NOT_FOUND, 'Resource not found'),
                Response::HTTP_NOT_FOUND,
                [
                    'Content-type' => 'application/json'
                ]
            );
        } catch (MethodNotAllowedException $e) {
            return new Response(
                new HttpMessage(Response::HTTP_METHOD_NOT_ALLOWED, 'Method not allowed'),
                Response::HTTP_METHOD_NOT_ALLOWED,
                [
                    'Content-type' => 'application/json'
                ]
            );
        }
    }
}
