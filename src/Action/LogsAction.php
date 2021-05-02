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

use App\Domain\User\Service\Plant;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Routing\RouteContext;

final class LogsAction
{
    private $logModel;

    public function __construct(Plant $logModel)
    {
        $this->logModel = $logModel;
    }

    public function index(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface {
        $user = $this->session->get('user');
        if ($user["role"] != "admin") {
            $routeParser = RouteContext::fromRequest($request)->getRouteParser();
            return $response->withStatus(403)->withHeader('Location', $routeParser->urlFor('dashboard'));
        }

        $list = $this->logModel->getUsersList();

        $this->renderer->addAttribute('user', $user);
        $this->renderer->addAttribute('list', $list);
        return $this->renderer->render($response, 'users/list.php');
    }

    public function view(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface {
        $user = $this->session->get('user');

        $detail = $this->logModel->getUser($data["userid"], $data["email"]);

        $this->renderer->addAttribute('user', $user);
        $this->renderer->addAttribute('detail', $detail);
        return $this->renderer->render($response, 'users/detail.php');
    }

}