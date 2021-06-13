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

    /**
     * @var UserLogin
     */
    private $userLogin;

    /**
     * @var SessionInterface
     */
    private $session;

    /**
     * LoginAction constructor.
     * @param PhpRenderer $renderer
     * @param UserLogin $userLogin
     * @param SessionInterface $session
     */
    public function __construct(PhpRenderer $renderer, UserLogin $userLogin, SessionInterface $session)
    {
        //initiates all the variables that will be needed in the functions
        $this->session = $session;
        $this->renderer = $renderer;
        $this->userLogin = $userLogin;
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     * @throws \Throwable
     */
    public function login(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface {
        //returns the login page
        return $this->renderer->render($response, 'login.php');
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     * @throws \Throwable
     */
    public function loginCheck(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface {
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
        // if there is a user with the given credentials, it will do the login, create a session and redirect to the
        // dashboard
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
            // if not, it will return to the login page with the error message to be displayed
            return $this->renderer->render($response, 'login.php', ['message_error' => $userLoggedIn["message"]]);
        }

    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
    public function logout(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface {
        // Logout user, destroys the session and redirects to the login page
        $this->session->destroy();

        $routeParser = RouteContext::fromRequest($request)->getRouteParser();
        $url = $routeParser->urlFor('login');

        return $response->withStatus(302)->withHeader('Location', $url);
    }

}
