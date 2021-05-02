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
use App\Domain\Log\Service\Log;

final class ApiAction
{
    private $logModel;

    public function __construct(Log $logModel)
    {
        $this->logModel = $logModel;
    }

    public function index(ResponseInterface $response): ResponseInterface {
        $response->getBody()->write(json_encode(['version' => '1.0']));

        return $response->withHeader('Content-Type', 'application/json'); //->withStatus(422);
    }


    public function device(
        ServerRequestInterface $request,
        ResponseInterface $response
    ): ResponseInterface {
        // TODO save info in BD
        $response->getBody()->write(json_encode(['msg' => 'Log saved with success']));

        return $response->withHeader('Content-Type', 'application/json'); //->withStatus(422);
    }



    public function addLog(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface {
        $user = $this->session->get('user');
        if ($user["role"] != "admin") {
            // Get RouteParser from request to generate the urls
            $routeParser = RouteContext::fromRequest($request)->getRouteParser();
            return $response->withStatus(403)->withHeader('Location', $routeParser->urlFor('dashboard'));
        }


        // Collect input from the HTTP request
        $data = (array)$request->getParsedBody();
        // Invoke the Domain with inputs and retain the result
        $userId = $this->logModel->createLog($data);
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

    public function getLog(ServerRequestInterface $request, ResponseInterface $response, $params): ResponseInterface {
        $user = $this->session->get('user');
        if ($user["role"] != "admin") {
            $routeParser = RouteContext::fromRequest($request)->getRouteParser();
            return $response->withStatus(403)->withHeader('Location', $routeParser->urlFor('dashboard'));
        }
        $this->logModel->getLastLog($params);

        $this->renderer->addAttribute('user', $user);
        return $this->renderer->render($response, 'users/list.php');
    }
}
