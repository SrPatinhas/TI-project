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
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Routing\RouteContext;

final class PlantsAction
{
    private $userModel;

    public function __construct(User $userModel)
    {
        $this->userModel = $userModel;
    }

    public function index(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface {
        $user = $this->session->get('user');
        if ($user["role"] != "admin") {
            $routeParser = RouteContext::fromRequest($request)->getRouteParser();
            return $response->withStatus(403)->withHeader('Location', $routeParser->urlFor('dashboard'));
        }

        $list = $this->userModel->getUsersList();

        $this->renderer->addAttribute('user', $user);
        $this->renderer->addAttribute('list', $list);
        return $this->renderer->render($response, 'users/list.php');
    }

    public function detail(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface {
        $user = $this->session->get('user');
        if ($user["role"] != "admin") {
            $routeParser = RouteContext::fromRequest($request)->getRouteParser();
            return $response->withStatus(403)->withHeader('Location', $routeParser->urlFor('dashboard'));
        }

        // Collect input from the HTTP request
        $data = (array)$request->getParsedBody();

        $detail = $this->userModel->getUser($data["userid"], $data["email"]);

        $this->renderer->addAttribute('user', $user);
        $this->renderer->addAttribute('detail', $detail);
        return $this->renderer->render($response, 'users/detail.php');
    }

    public function new(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface {
        $user = $this->session->get('user');
        if ($user["role"] != "admin") {
            $routeParser = RouteContext::fromRequest($request)->getRouteParser();
            return $response->withStatus(403)->withHeader('Location', $routeParser->urlFor('dashboard'));
        }

        $this->renderer->addAttribute('user', $user);
        return $this->renderer->render($response, 'users/new.php');
    }

    public function create(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface {
        $user = $this->session->get('user');
        if ($user["role"] != "admin") {
            // Get RouteParser from request to generate the urls
            $routeParser = RouteContext::fromRequest($request)->getRouteParser();
            return $response->withStatus(403)->withHeader('Location', $routeParser->urlFor('dashboard'));
        }


        // Collect input from the HTTP request
        $data = (array)$request->getParsedBody();
        // Invoke the Domain with inputs and retain the result
        $userId = $this->userModel->createUser($data);
        // Transform the result into the JSON representation
        $result = [
            'user_id' => $userId
        ];
        // Build the HTTP response
        $response->getBody()->write((string)json_encode($result));

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(201);
    }


    public function update(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface {
        $user = $this->session->get('user');
        if ($user["role"] != "admin") {
            // Get RouteParser from request to generate the urls
            $routeParser = RouteContext::fromRequest($request)->getRouteParser();
            return $response->withStatus(403)->withHeader('Location', $routeParser->urlFor('dashboard'));
        }
        // Collect input from the HTTP request
        $data = (array)$request->getParsedBody();
        // Invoke the Domain with inputs and retain the result
        $detail = $this->userModel->updateUser($data);
        // Transform the result into the JSON representation
        $result = [
            'user_id' => $userId
        ];

        $this->renderer->addAttribute('user', $user);
        $this->renderer->addAttribute('detail', $detail);
        return $this->renderer->render($response, 'users/detail.php');
    }

    public function delete(ServerRequestInterface $request, ResponseInterface $response, $id): ResponseInterface {
        $user = $this->session->get('user');
        if ($user["role"] != "admin") {
            $routeParser = RouteContext::fromRequest($request)->getRouteParser();
            return $response->withStatus(403)->withHeader('Location', $routeParser->urlFor('dashboard'));
        }
        $this->userModel->deleteUser($id);

        $this->renderer->addAttribute('user', $user);
        return $this->renderer->render($response, 'users/list.php');
    }
}