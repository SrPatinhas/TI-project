<?php
/**
 * Created by PhpStorm.
 * Project: TI
 * User: Miguel Cerejo
 * Date: 4/27/2021
 * Time: 3:21 AM
 *
 * File: ErrorMiddleware.php
 */

namespace App\Middleware;

use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Exception\HttpException;
use Slim\Views\PhpRenderer;

final class HttpExceptionMiddleware implements MiddlewareInterface
{
    /**
     * @var ResponseFactoryInterface
     */
    private $responseFactory;
    /**
     * @var PhpRenderer
     */
    private $renderer;

    public function __construct(PhpRenderer $renderer, ResponseFactoryInterface $responseFactory)
    {
        $this->responseFactory = $responseFactory;
        $this->renderer = $renderer;
    }

    public function process(
        ServerRequestInterface $request,
        RequestHandlerInterface $handler
    ): ResponseInterface
    {
        try {
            return $handler->handle($request);
        } catch (HttpException $httpException) {
            // Handle the http exception here
            $statusCode = $httpException->getCode();
            $response = $this->responseFactory->createResponse()->withStatus($statusCode);
            $errorMessage = sprintf('%s %s', $statusCode, $response->getReasonPhrase());

            // Log the error message
            // $this->logger->error($errorMessage);

            // Render twig template or just add the content to the body
            //$response->getBody()->write($errorMessage);

            return $this->renderer->render($response, '404.php', ["error" => ["code" => $statusCode, "message" => $errorMessage]]);
            //return $response;
        }
    }
}