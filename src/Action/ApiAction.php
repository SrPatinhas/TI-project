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
use App\Domain\Log\Service\Log;

final class ApiAction
{

    private $logModel;
    private $userModel;

    public function __construct(Log $logModel, UserLogin $userModel)
    {
        $this->logModel = $logModel;
        $this->userModel = $userModel;
    }

    public function index(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface {
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
        $user = isset($_SERVER['PHP_AUTH_USER']) ? $_SERVER['PHP_AUTH_USER'] : '';
        $pass = isset($_SERVER['PHP_AUTH_PW']) ? $_SERVER['PHP_AUTH_PW'] : '';

        $is_valid = $this->userModel->checkUserLogin($user, $pass);

        if (!$is_valid) {
            // Build the HTTP response
            $response->getBody()->write((string)json_encode(['error' => 'user unauthenticated']));
            return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(401);
        }

        // Collect input from the HTTP request
        $data = (array)$request->getParsedBody();

        // Invoke the Domain with inputs and retain the result
        $log = $this->logModel->createLog($data);
        // Transform the result into the JSON representation
        $result = [
            'log_id' => $log["id"]
        ];
        // Build the HTTP response
        $response->getBody()->write((string)json_encode($result));

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(201);
    }

    public function getLog(ServerRequestInterface $request, ResponseInterface $response, $params): ResponseInterface {
        $user = isset($_SERVER['PHP_AUTH_USER']) ? $_SERVER['PHP_AUTH_USER'] : '';
        $pass = isset($_SERVER['PHP_AUTH_PW']) ? $_SERVER['PHP_AUTH_PW'] : '';

        $is_valid = $this->userModel->checkUserLogin($user, $pass);

        if (!$is_valid) {
            // Build the HTTP response
            $response->getBody()->write((string)json_encode(['error' => 'user unauthenticated']));
            return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(401);
        }

        $result = $this->logModel->getLastLog($params['line'], $params['position']);

        // Build the HTTP response
        $response->getBody()->write((string)json_encode($result));

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(201);
    }
}
