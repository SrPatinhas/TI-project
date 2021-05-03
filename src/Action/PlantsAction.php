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

/**
 * Class PlantsAction
 * @package App\Action
 */
final class PlantsAction
{
    /**
     * @var Plant
     */
    private $plantModel;

    /**
     * @var Log
     */
    private $logModel;
    /**
     * @var SessionInterface
     */
    private $session;
    /**
     * @var PhpRenderer
     */
    private $renderer;

    /**
     * @var mixed
     */
    private $greenhouse;

    /**
     * @var mixed|null
     */
    private $userSession;

    /**
     * PlantsAction constructor.
     * @param ContainerInterface $container
     * @param Plant $plantModel
     * @param Log $logModel
     * @param PhpRenderer $renderer
     * @param SessionInterface $session
     */
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


    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     * @throws \Throwable
     */
    public function index(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface {
        if ($this->userSession["role"] == "user") {
            $list = $this->plantModel->getPlantsListByUser($this->userSession["id"]);
        } else {
            $list = $this->plantModel->getPlantsList();
        }

        $this->renderer->addAttribute('list', $list);
        return $this->renderer->render($response, 'plants/list.php');
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param $params
     * @return ResponseInterface
     * @throws \Throwable
     */
    public function view(ServerRequestInterface $request, ResponseInterface $response, $params): ResponseInterface {
        $detail = $this->plantModel->getPlant((int)$params["id"]);
        $logs = $this->logModel->getLogByPlant($detail["line"], $detail["position"]);

        $this->renderer->addAttribute('detail', $detail);
        $this->renderer->addAttribute('logs', $logs);
        return $this->renderer->render($response, 'plants/view.php');
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param $params
     * @return ResponseInterface
     * @throws \Throwable
     */
    public function detail(ServerRequestInterface $request, ResponseInterface $response, $params): ResponseInterface {
        $detail = $this->plantModel->getPlant((int)$params["id"]);
        $this->renderer->addAttribute('detail', $detail);
        return $this->renderer->render($response, 'plants/detail.php');
    }


    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param $params
     * @return ResponseInterface
     * @throws \Throwable
     */
    public function edit(ServerRequestInterface $request, ResponseInterface $response, $params): ResponseInterface {
        $detail = $this->plantModel->getPlant((int)$params["id"]);
        $this->renderer->addAttribute('detail', $detail);
        return $this->renderer->render($response, 'plants/edit.php');
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     * @throws \Throwable
     */
    public function new(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface {
        $this->renderer->addAttribute('detail', []);
        return $this->renderer->render($response, 'plants/edit.php');
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     * @throws \Throwable
     */
    public function create(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface {
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


    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     * @throws \Throwable
     */
    public function update(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface {
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
        // Get RouteParser from request to generate the urls
        $routeParser = RouteContext::fromRequest($request)->getRouteParser();
        return $response->withStatus(403)->withHeader('Location', $routeParser->urlFor('plants-detail', ["id" => $detail["id"]]));
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param $params
     * @return ResponseInterface
     */
    public function delete(ServerRequestInterface $request, ResponseInterface $response, $params): ResponseInterface {
        $routeParser = RouteContext::fromRequest($request)->getRouteParser();

        if ($this->userSession["role"] != "admin") {
            return $response->withStatus(403)->withHeader('Location', $routeParser->urlFor('dashboard'));
        }
        $this->plantModel->deletePlant($params['id']);
        return $response->withStatus(403)->withHeader('Location', $routeParser->urlFor('plants'));
    }
}