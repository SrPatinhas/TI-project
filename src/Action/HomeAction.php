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

    public function __construct(PhpRenderer $renderer, SessionInterface $session)
    {
        $this->renderer = $renderer;
        $this->session = $session;
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

    public function dashboard(
        ServerRequestInterface $request,
        ResponseInterface $response
    ): ResponseInterface {
        $user = $this->session->get('user');
        // optional
        $this->renderer->addAttribute('user', $user);
        return $this->renderer->render($response, 'dashboard.php');
    }
}
