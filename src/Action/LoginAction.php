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

use App\Domain\User\Service\UserLogin;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\PhpRenderer;
use Odan\Session\SessionInterface;
use Slim\Routing\RouteContext;

final class LoginAction
{
    /**
     * @var PhpRenderer
     */
    private $renderer;

    private $userLogin;

    /**
     * @var SessionInterface
     */
    private $session;

    public function __construct(PhpRenderer $renderer, UserLogin $userLogin, SessionInterface $session)
    {
        $this->session = $session;
        $this->renderer = $renderer;
        $this->userLogin = $userLogin;
    }

    //public function __invoke(
    public function login(
        ServerRequestInterface $request,
        ResponseInterface $response
    ): ResponseInterface {
        return $this->renderer->render($response, 'login.php');
    }

    public function loginCheck(
        ServerRequestInterface $request,
        ResponseInterface $response
    ): ResponseInterface {
        // Collect input from the HTTP request
        $data = (array)$request->getParsedBody();
        $email = (string)($data['email'] ?? '');
        $password = (string)($data['password'] ?? '');

        // Pseudo example
        // Check user credentials. You may use an application/domain service and the database here.
        $userLoggedIn = null;
        $userLoggedIn = $this->userLogin->loginUser([
            "email" => $email,
            "password" => $password,
        ]);

        if ($userLoggedIn["user"]) {
            // Get RouteParser from request to generate the urls
            $routeParser = RouteContext::fromRequest($request)->getRouteParser();
            // Login successfully
            // Clears all session data and regenerate session ID
            $this->session->destroy();
            $this->session->start();
            $this->session->regenerateId();

            $this->session->set('user', $userLoggedIn);

            // Redirect to protected page
            return $response->withStatus(302)->withHeader('Location', $routeParser->urlFor('dashboard'));
        } else {
            return $this->renderer->render($response, 'login.php', ['message_error' => $userLoggedIn["message"]]);
        }

    }

    public function logout(
        ServerRequestInterface $request,
        ResponseInterface $response
    ): ResponseInterface {
        // Logout user
        $this->session->destroy();

        $routeParser = RouteContext::fromRequest($request)->getRouteParser();
        $url = $routeParser->urlFor('login');

        return $response->withStatus(302)->withHeader('Location', $url);
    }

}
