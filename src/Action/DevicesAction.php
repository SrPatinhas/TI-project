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

use App\Domain\Device\Service\Device;
use App\Domain\Log\Service\Log;
use Odan\Session\SessionInterface;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Routing\RouteContext;
use Slim\Views\PhpRenderer;

final class DevicesAction
{
    /**
     * @var SessionInterface
     */
    private $session;
    /**
     * @var PhpRenderer
     */
    private $renderer;

    /**
     * @var Device
     */
    private $deviceModel;

    /**
     * @var Log
     */
    private $logModel;

    /**
     * @var mixed
     */
    private $greenhouse;

    /**
     * @var mixed|null
     */
    private $userSession;

    /**
     * DevicesAction constructor.
     * @param Device $deviceModel
     * @param Log $logModel
     * @param ContainerInterface $container
     * @param PhpRenderer $renderer
     * @param SessionInterface $session
     */
    public function __construct(Device $deviceModel, Log $logModel, ContainerInterface $container, PhpRenderer $renderer, SessionInterface $session)
    {
        $this->renderer = $renderer;
        $this->session = $session;
        $this->deviceModel = $deviceModel;
        $this->logModel = $logModel;
        $this->greenhouse = $container->get('greenhouse');
        $this->renderer->addAttribute('greenhouse', $this->greenhouse);

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
        $list = $this->deviceModel->getDevicesList();

        $this->renderer->addAttribute('list', $list);
        return $this->renderer->render($response, 'devices/list.php');
    }


    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param $params
     * @return ResponseInterface
     * @throws \Throwable
     */
    public function view(ServerRequestInterface $request, ResponseInterface $response, $params): ResponseInterface {
        if ($this->userSession["role"] == "user") {
            $routeParser = RouteContext::fromRequest($request)->getRouteParser();
            return $response->withStatus(403)->withHeader('Location', $routeParser->urlFor('dashboard'));
        }
        $detail = $this->deviceModel->getDevice((int)$params["id"]);
        $logs = $this->logModel->getLogByDevice((int)$params["id"]);
        $categories = $this->deviceModel->getCategoriesList();

        $this->renderer->addAttribute('detail', $detail);
        $this->renderer->addAttribute('logs', $logs);
        $this->renderer->addAttribute('categories', $categories);
        return $this->renderer->render($response, 'devices/view.php');
    }


    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param $params
     * @return ResponseInterface
     * @throws \Throwable
     */
    public function detail(ServerRequestInterface $request, ResponseInterface $response, $params): ResponseInterface {
        if ($this->userSession["role"] == "user") {
            $routeParser = RouteContext::fromRequest($request)->getRouteParser();
            return $response->withStatus(403)->withHeader('Location', $routeParser->urlFor('dashboard'));
        }
        $detail = $this->deviceModel->getDevice((int)$params["id"]);
        $categories = $this->deviceModel->getCategoriesList();

        $this->renderer->addAttribute('detail', $detail);
        $this->renderer->addAttribute('categories', $categories);
        return $this->renderer->render($response, 'devices/detail.php');
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param $params
     * @return ResponseInterface
     * @throws \Throwable
     */
    public function edit(ServerRequestInterface $request, ResponseInterface $response, $params): ResponseInterface {
        if ($this->userSession["role"] == "user") {
            $routeParser = RouteContext::fromRequest($request)->getRouteParser();
            return $response->withStatus(403)->withHeader('Location', $routeParser->urlFor('dashboard'));
        }

        $detail = $this->deviceModel->getDevice((int)$params["id"]);
        $categories = $this->deviceModel->getCategoriesList();

        $this->renderer->addAttribute('detail', $detail);
        $this->renderer->addAttribute('categories', $categories);
        return $this->renderer->render($response, 'devices/edit.php');
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     * @throws \Throwable
     */
    public function new(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface {
        if ($this->userSession["role"] == "user") {
            $routeParser = RouteContext::fromRequest($request)->getRouteParser();
            return $response->withStatus(403)->withHeader('Location', $routeParser->urlFor('dashboard'));
        }
        $categories = $this->deviceModel->getCategoriesList();
        $this->renderer->addAttribute('detail', []);
        $this->renderer->addAttribute('categories', $categories);
        return $this->renderer->render($response, 'devices/edit.php');
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     * @throws \Throwable
     */
    public function create(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface {
        if ($this->userSession["role"] == "user") {
            // Get RouteParser from request to generate the urls
            $routeParser = RouteContext::fromRequest($request)->getRouteParser();
            return $response->withStatus(403)->withHeader('Location', $routeParser->urlFor('dashboard'));
        }

        // Collect input from the HTTP request
        $data = (array)$request->getParsedBody();

        $grid = explode("-", $data["grid-position"]);
        $data["line"] = $grid[0];
        $data["position"] = $grid[1];

        // Invoke the Domain with inputs and retain the result
        $device = $this->deviceModel->createDevice($data);

        if (!isset($device["id"])) {
            $categories = $this->deviceModel->getCategoriesList();
            $this->renderer->addAttribute('detail', $data);
            $this->renderer->addAttribute('errors', $device);
            $this->renderer->addAttribute('categories', $categories);
            return $this->renderer->render($response, 'devices/edit.php');
        }

        $routeParser = RouteContext::fromRequest($request)->getRouteParser();
        return $response->withStatus(403)->withHeader('Location', $routeParser->urlFor('devices-detail', ["id" => $device["id"]]));
    }


    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
    public function update(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface {
        if ($this->userSession["role"] == "user") {
            // Get RouteParser from request to generate the urls
            $routeParser = RouteContext::fromRequest($request)->getRouteParser();
            return $response->withStatus(403)->withHeader('Location', $routeParser->urlFor('dashboard'));
        }
        // Collect input from the HTTP request
        $data = (array)$request->getParsedBody();

        $grid = explode("-", $data["grid-position"]);
        $data["line"] = $grid[0];
        $data["position"] = $grid[1];

        // Invoke the Domain with inputs and retain the result
        $detail = $this->deviceModel->updateDevice($data);

        $routeParser = RouteContext::fromRequest($request)->getRouteParser();
        return $response->withStatus(403)->withHeader('Location', $routeParser->urlFor('devices-detail', ["id" => $detail["id"]]));
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param $id
     * @return ResponseInterface
     */
    public function delete(ServerRequestInterface $request, ResponseInterface $response, $id): ResponseInterface {
        if ($this->userSession["role"] != "admin") {
            $routeParser = RouteContext::fromRequest($request)->getRouteParser();
            return $response->withStatus(403)->withHeader('Location', $routeParser->urlFor('dashboard'));
        }
        $this->deviceModel->deleteDevice($id);

        $routeParser = RouteContext::fromRequest($request)->getRouteParser();
        return $response->withStatus(403)->withHeader('Location', $routeParser->urlFor('devices'));
    }
}