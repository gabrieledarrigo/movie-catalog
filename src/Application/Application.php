<?php
declare(strict_types=1);

namespace Darrigo\MovieCatalog\Application;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouteCollection;

class Application
{
    public function init()
    {
        $request = Request::createFromGlobals();
        $routes = new RouteCollection();

        $context = new RequestContext();
        $context->fromRequest($request);

        $front = new FrontController(new UrlMatcher($routes, $context));
        $front->handle($request);
    }
}
