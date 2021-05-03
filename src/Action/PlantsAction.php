<?php
/**
 * Created by PhpStorm.
 * Project: TI
 * User: Miguel Cerejo
 * Date: 4/25/2021
 * Time: 6:05 PM
 *
 * File: PlantCreateAction.php
 */

namespace App\Action;

use App\Domain\Log\Service\Log;
use App\Domain\Plant\Service\Plant;
use Odan\Session\SessionInterface;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Routing\RouteContext;
use Slim\Views\PhpRenderer;

final class PlantsAction
{
    private $plantModel;

    private $logModel;
    /**
     * @var SessionInterface
     */
    private $session;
    /**
     * @var PhpRenderer
     */
    private $renderer;

    private $greenhouse;

    private $userSession;

    public function __construct(ContainerInterface $container, Plant $plantModel, Log $logModel, PhpRenderer $renderer, SessionInterface $session)
    {
        $this->renderer = $renderer;
        $this->plantModel = $plantModel;
        $this->session = $session;
        $this->logModel = $logModel;
        $this->greenhouse = $container->get('greenhouse');

        // Get user logged on and share it to the page
        $this->userSession = $this->session->get('user');
        $this->renderer->addAttribute('user', $this->userSession);
        $this->renderer->addAttribute('greenhouse', $this->greenhouse);
    }


    public function index(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface {
        if ($this->userSession["role"] != "admin") {
            $routeParser = RouteContext::fromRequest($request)->getRouteParser();
            return $response->withStatus(403)->withHeader('Location', $routeParser->urlFor('dashboard'));
        }
        $list = $this->plantModel->getPlantsList();

        $this->renderer->addAttribute('list', $list);
        return $this->renderer->render($response, 'plants/list.php');
    }

    public function view(ServerRequestInterface $request, ResponseInterface $response, $params): ResponseInterface {
        if ($this->userSession["role"] != "admin") {
            $routeParser = RouteContext::fromRequest($request)->getRouteParser();
            return $response->withStatus(403)->withHeader('Location', $routeParser->urlFor('dashboard'));
        }

        $detail = $this->plantModel->getPlant((int)$params["id"]);
        $logs = $this->logModel->getLogByPlant($detail["line"], $detail["position"]);

        $this->renderer->addAttribute('detail', $detail);
        $this->renderer->addAttribute('logs', $logs);
        return $this->renderer->render($response, 'plants/view.php');
    }

    public function detail(ServerRequestInterface $request, ResponseInterface $response, $params): ResponseInterface {
        if ($this->userSession["role"] != "admin") {
            $routeParser = RouteContext::fromRequest($request)->getRouteParser();
            return $response->withStatus(403)->withHeader('Location', $routeParser->urlFor('dashboard'));
        }

        $detail = $this->plantModel->getPlant((int)$params["id"]);
        $this->renderer->addAttribute('detail', $detail);
        return $this->renderer->render($response, 'plants/detail.php');
    }


    public function edit(ServerRequestInterface $request, ResponseInterface $response, $params): ResponseInterface {
        if ($this->userSession["role"] != "admin") {
            $routeParser = RouteContext::fromRequest($request)->getRouteParser();
            return $response->withStatus(403)->withHeader('Location', $routeParser->urlFor('dashboard'));
        }

        $detail = $this->plantModel->getPlant((int)$params["id"]);

        $this->renderer->addAttribute('detail', $detail);
        return $this->renderer->render($response, 'plants/edit.php');
    }

    public function new(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface {
        if ($this->userSession["role"] != "admin") {
            $routeParser = RouteContext::fromRequest($request)->getRouteParser();
            return $response->withStatus(403)->withHeader('Location', $routeParser->urlFor('dashboard'));
        }

        $this->renderer->addAttribute('detail', []);
        return $this->renderer->render($response, 'plants/edit.php');
    }

    public function create(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface {
        if ($this->userSession["role"] != "admin") {
            // Get RouteParser from request to generate the urls
            $routeParser = RouteContext::fromRequest($request)->getRouteParser();
            return $response->withStatus(403)->withHeader('Location', $routeParser->urlFor('dashboard'));
        }

        // Collect input from the HTTP request
        $data = (array)$request->getParsedBody();

        $data["created_by"] = $this->userSession["id"];
        $grid = explode("-", $data["grid-position"]);
        $data["line"] = $grid[0];
        $data["position"] = $grid[1];

        // Invoke the Domain with inputs and retain the result
        $plant = $this->plantModel->createPlant($data);

        if (!isset($plant["id"])) {
            $this->renderer->addAttribute('detail', $data);
            return $this->renderer->render($response, 'plants/edit.php');
        }

        $routeParser = RouteContext::fromRequest($request)->getRouteParser();
        return $response->withStatus(403)->withHeader('Location', $routeParser->urlFor('plants-detail', ["id" => $plant["id"]]));
    }


    public function update(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface {
        // Get RouteParser from request to generate the urls
        $routeParser = RouteContext::fromRequest($request)->getRouteParser();

        if ($this->userSession["role"] != "admin") {
            return $response->withStatus(403)->withHeader('Location', $routeParser->urlFor('dashboard'));
        }
        // Collect input from the HTTP request
        $data = (array)$request->getParsedBody();

        $grid = explode("-", $data["grid-position"]);
        $data["line"] = $grid[0];
        $data["position"] = $grid[1];

        // Invoke the Domain with inputs and retain the result
        $detail = $this->plantModel->updatePlant($data);

        if (!isset($detail["id"])) {
            $this->renderer->addAttribute('detail', $data);
            $this->renderer->addAttribute('errors', $detail);
            return $this->renderer->render($response, 'plants/edit.php');
        }

        return $response->withStatus(403)->withHeader('Location', $routeParser->urlFor('plants-detail', ["id" => $detail["id"]]));
    }

    public function delete(ServerRequestInterface $request, ResponseInterface $response, $id): ResponseInterface {
        $routeParser = RouteContext::fromRequest($request)->getRouteParser();

        if ($this->userSession["role"] != "admin") {
            return $response->withStatus(403)->withHeader('Location', $routeParser->urlFor('dashboard'));
        }
        $this->plantModel->deletePlant($id);
        return $response->withStatus(403)->withHeader('Location', $routeParser->urlFor('plants'));
    }
}