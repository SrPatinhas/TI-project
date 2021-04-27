<?php
/**
 * Created by PhpStorm.
 * Project: TI
 * User: Miguel Cerejo
 * Date: 4/25/2021
 * Time: 6:49 PM
 *
 * File: PhpViewExtensionMiddleware.php
 */
namespace App\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\App;
use Slim\Views\PhpRenderer;

final class PhpViewExtensionMiddleware implements MiddlewareInterface
{
    /**
     * @var App
     */
    private $app;

    /**
     * @var PhpRenderer
     */
    private $phpRenderer;

    public function __construct(App $app, PhpRenderer $phpRenderer)
    {
        $this->phpRenderer = $phpRenderer;
        $this->app = $app;
    }

    public function process(
        ServerRequestInterface $request,
        RequestHandlerInterface $handler
    ): ResponseInterface {
        $this->phpRenderer->addAttribute('uri', $request->getUri());
        $this->phpRenderer->addAttribute('basePath', $this->app->getBasePath());
        $this->phpRenderer->addAttribute('route', $this->app->getRouteCollector()->getRouteParser());

        return $handler->handle($request);
    }
}