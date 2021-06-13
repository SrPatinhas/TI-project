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
        //initiates all the variables that will be needed in the functions
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
        //validates if the user is not an admin, will be redirect to the Dashboard page
        if ($this->userSession["role"] != "admin") {
            $routeParser = RouteContext::fromRequest($request)->getRouteParser();
            return $response->withStatus(403)->withHeader('Location', $routeParser->urlFor('dashboard'));
        }
        // gets the users list
        $list = $this->userModel->getUsersList();

        //adds the variables to the renderer function so we can use it in the template page
        $this->renderer->addAttribute('list', $list);
        // returns the page that we want to render
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
        //validates if the user is not an admin, will be redirect to the Dashboard page
        if ($this->userSession["role"] != "admin") {
            $routeParser = RouteContext::fromRequest($request)->getRouteParser();
            return $response->withStatus(403)->withHeader('Location', $routeParser->urlFor('dashboard'));
        }
        // gets the user detail to view only
        $detail = $this->userModel->getUser( (int) $params["id"]);
        //adds the variables to the renderer function so we can use it in the template page
        $this->renderer->addAttribute('detail', $detail);
        // returns the page that we want to render
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
        //validates if the user is not an admin, will be redirect to the Dashboard page
        if ($this->userSession["role"] != "admin") {
            $routeParser = RouteContext::fromRequest($request)->getRouteParser();
            return $response->withStatus(403)->withHeader('Location', $routeParser->urlFor('dashboard'));
        }
        // gets the user detail to edit
        $detail = $this->userModel->getUser( (int) $params["id"]);
        //adds the variables to the renderer function so we can use it in the template page
        $this->renderer->addAttribute('detail', $detail);
        // returns the page that we want to render
        return $this->renderer->render($response, 'users/edit.php');
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     * @throws \Throwable
     */
    public function new(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface {
        //validates if the user is not an admin, will be redirect to the Dashboard page
        if ($this->userSession["role"] != "admin") {
            $routeParser = RouteContext::fromRequest($request)->getRouteParser();
            return $response->withStatus(403)->withHeader('Location', $routeParser->urlFor('dashboard'));
        }
        // returns a empty array, so we prevent any runtime error
        //adds the variable to the response, so we can use it in the template
        $this->renderer->addAttribute('detail', []);
        // returns the page that we want to render
        return $this->renderer->render($response, 'users/edit.php');
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     * @throws \Throwable
     */
    public function create(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface {
        //validates if the user is not an admin, will be redirect to the Dashboard page
        if ($this->userSession["role"] != "admin") {
            // Get RouteParser from request to generate the urls
            $routeParser = RouteContext::fromRequest($request)->getRouteParser();
            return $response->withStatus(403)->withHeader('Location', $routeParser->urlFor('dashboard'));
        }

        // Collect input from the HTTP request
        $data = (array)$request->getParsedBody();
        // generates a generic password for any user created by the admin
        if($data["type"] == "create_admin") {
            $data["password"] = "Qwerty";
        }

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
        //validates if the user is not an admin, will be redirect to the Dashboard page
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
     * @param $params
     * @return ResponseInterface
     */
    public function delete(ServerRequestInterface $request, ResponseInterface $response, $params): ResponseInterface {
        $routeParser = RouteContext::fromRequest($request)->getRouteParser();
        //validates if the user is not an admin, will be redirect to the Dashboard page
        if ($this->userSession["role"] != "admin") {
            return $response->withStatus(403)->withHeader('Location', $routeParser->urlFor('dashboard'));
        }
        // deletes the user by a given ID
        $this->userModel->deleteUser($params['id']);
        // redirects to the users list page
        return $response->withStatus(403)->withHeader('Location', $routeParser->urlFor('users'));
    }
}