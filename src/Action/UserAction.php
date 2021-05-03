<?php
/**
 * Created by PhpStorm.
 * Project: TI
 * User: Miguel Cerejo
 * Date: 4/25/2021
 * Time: 6:05 PM
 *
 * File: UserCreateAction.php
 */

namespace App\Action;

use App\Domain\User\Service\User;
use Odan\Session\SessionInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Routing\RouteContext;
use Slim\Views\PhpRenderer;

/**
 * Class UserAction
 * @package App\Action
 */
final class UserAction
{
    /**
     * @var User
     */
    private $userModel;
    /**
     * @var SessionInterface
     */
    private $session;
    /**
     * @var PhpRenderer
     */
    private $renderer;

    /**
     * @var mixed|null
     */
    private $userSession;

    /**
     * UserAction constructor.
     * @param User $userModel
     * @param PhpRenderer $renderer
     * @param SessionInterface $session
     */
    public function __construct(User $userModel, PhpRenderer $renderer, SessionInterface $session)
    {
        $this->renderer = $renderer;
        $this->session = $session;
        $this->userModel = $userModel;

        // Get user logged on and share it to the page
        $this->userSession = $this->session->get('user');
        $this->renderer->addAttribute('user', $this->userSession);
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     * @throws \Throwable
     */
    public function index(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface {
        if ($this->userSession["role"] != "admin") {
            $routeParser = RouteContext::fromRequest($request)->getRouteParser();
            return $response->withStatus(403)->withHeader('Location', $routeParser->urlFor('dashboard'));
        }

        $list = $this->userModel->getUsersList();

        $this->renderer->addAttribute('list', $list);
        return $this->renderer->render($response, 'users/list.php');
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param $params
     * @return ResponseInterface
     * @throws \Throwable
     */
    public function detail(ServerRequestInterface $request, ResponseInterface $response, $params): ResponseInterface {
        if ($this->userSession["role"] != "admin") {
            $routeParser = RouteContext::fromRequest($request)->getRouteParser();
            return $response->withStatus(403)->withHeader('Location', $routeParser->urlFor('dashboard'));
        }

        $detail = $this->userModel->getUser( (int) $params["id"]);

        $this->renderer->addAttribute('detail', $detail);
        return $this->renderer->render($response, 'users/detail.php');
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param $params
     * @return ResponseInterface
     * @throws \Throwable
     */
    public function edit(ServerRequestInterface $request, ResponseInterface $response, $params): ResponseInterface {
        if ($this->userSession["role"] != "admin") {
            $routeParser = RouteContext::fromRequest($request)->getRouteParser();
            return $response->withStatus(403)->withHeader('Location', $routeParser->urlFor('dashboard'));
        }

        $detail = $this->userModel->getUser( (int) $params["id"]);

        $this->renderer->addAttribute('detail', $detail);
        return $this->renderer->render($response, 'users/edit.php');
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     * @throws \Throwable
     */
    public function new(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface {
        if ($this->userSession["role"] != "admin") {
            $routeParser = RouteContext::fromRequest($request)->getRouteParser();
            return $response->withStatus(403)->withHeader('Location', $routeParser->urlFor('dashboard'));
        }

        $this->renderer->addAttribute('detail', []);
        return $this->renderer->render($response, 'users/edit.php');
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     * @throws \Throwable
     */
    public function create(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface {
        if ($this->userSession["role"] != "admin") {
            // Get RouteParser from request to generate the urls
            $routeParser = RouteContext::fromRequest($request)->getRouteParser();
            return $response->withStatus(403)->withHeader('Location', $routeParser->urlFor('dashboard'));
        }

        // Collect input from the HTTP request
        $data = (array)$request->getParsedBody();
        // Invoke the Domain with inputs and retain the result
        $user = $this->userModel->createUser($data);

        if (!isset($user["id"])) {
            $this->renderer->addAttribute('detail', $data);
            return $this->renderer->render($response, 'users/edit.php');
        }

        $routeParser = RouteContext::fromRequest($request)->getRouteParser();
        return $response->withStatus(403)->withHeader('Location', $routeParser->urlFor('users-detail', ["id" => $user["id"]]));
    }


    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     * @throws \Throwable
     */
    public function update(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface {
        if ($this->userSession["role"] != "admin") {
            // Get RouteParser from request to generate the urls
            $routeParser = RouteContext::fromRequest($request)->getRouteParser();
            return $response->withStatus(403)->withHeader('Location', $routeParser->urlFor('dashboard'));
        }
        // Collect input from the HTTP request
        $data = (array)$request->getParsedBody();
        // Invoke the Domain with inputs and retain the result
        $detail = $this->userModel->updateUser($data);
        // Transform the result into the JSON representation
        if (!isset($detail["id"])) {
            $this->renderer->addAttribute('detail', $data);
            $this->renderer->addAttribute('errors', $detail);
            return $this->renderer->render($response, 'users/edit.php');
        }
        $routeParser = RouteContext::fromRequest($request)->getRouteParser();
        return $response->withStatus(403)->withHeader('Location', $routeParser->urlFor('users-detail', ["id" => $detail["id"]]));
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param $id
     * @return ResponseInterface
     */
    public function delete(ServerRequestInterface $request, ResponseInterface $response, $id): ResponseInterface {
        $routeParser = RouteContext::fromRequest($request)->getRouteParser();
        if ($this->userSession["role"] != "admin") {
            return $response->withStatus(403)->withHeader('Location', $routeParser->urlFor('dashboard'));
        }
        $this->userModel->deleteUser($id);

        return $response->withStatus(403)->withHeader('Location', $routeParser->urlFor('users'));
    }
}