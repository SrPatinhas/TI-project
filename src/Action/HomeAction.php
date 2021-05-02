<?php
/**
 * Created by PhpStorm.
 * Project: TI
 * User: Miguel Cerejo
 * Date: 4/25/2021
 * Time: 3:42 PM
 *
 * File: HomeAction.php
 */

namespace App\Action;

use App\Domain\Plant\Service\Plant;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Routing\RouteContext;
use Slim\Views\PhpRenderer;
use Odan\Session\SessionInterface;

final class HomeAction
{
    /**
     * @var PhpRenderer
     */
    private $renderer;
    /**
     * @var SessionInterface
     */
    private $session;

    private $plantModel;

    public function __construct(PhpRenderer $renderer, SessionInterface $session, Plant $plantModel)
    {
        $this->renderer = $renderer;
        $this->session = $session;
        $this->plantModel = $plantModel;
    }

    public function home(
        ServerRequestInterface $request,
        ResponseInterface $response
    ): ResponseInterface {
        // Get RouteParser from request to generate the urls
        $routeParser = RouteContext::fromRequest($request)->getRouteParser();
        $user = $this->session->get('user');
        if ($user) {
            return $response->withStatus(302)->withHeader('Location', $routeParser->urlFor('dashboard'));
        }
        return $response->withStatus(302)->withHeader('Location', $routeParser->urlFor('login'));
    }

    public function dashboard(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface {
        $user = $this->session->get('user');
        // optional
        $this->renderer->addAttribute('user', $user);
        return $this->renderer->render($response, 'dashboard.php');
    }

    public function webcams(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface {
        $user = $this->session->get('user');
        if ($user["role"] != "admin") {
            // Get RouteParser from request to generate the urls
            $routeParser = RouteContext::fromRequest($request)->getRouteParser();
            return $response->withStatus(403)->withHeader('Location', $routeParser->urlFor('dashboard'));
        }

        $webcams = $this->plantModel->getWebcamsList();

        // optional
        $this->renderer->addAttribute('user', $user);
        $this->renderer->addAttribute('webcams', $webcams);
        return $this->renderer->render($response, 'webcams.php');
    }

    public function settings(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface {
        $user = $this->session->get('user');
        if ($user["role"] != "admin") {
            // Get RouteParser from request to generate the urls
            $routeParser = RouteContext::fromRequest($request)->getRouteParser();
            return $response->withStatus(403)->withHeader('Location', $routeParser->urlFor('dashboard'));
        }
        // optional
        $this->renderer->addAttribute('user', $user);
        return $this->renderer->render($response, 'settings.php');
    }
}
