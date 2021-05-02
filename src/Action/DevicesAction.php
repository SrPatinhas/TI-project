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

    private $deviceModel;

    private $greenhouse;

    public function __construct(Device $deviceModel, ContainerInterface $container, PhpRenderer $renderer, SessionInterface $session)
    {
        $this->renderer = $renderer;
        $this->session = $session;
        $this->deviceModel = $deviceModel;
        $this->greenhouse = $container->get('greenhouse');
    }

    public function index(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface {
        $user = $this->session->get('user');

        $list = $this->deviceModel->getDevicesList();
        // optional
        $this->renderer->addAttribute('user', $user);
        $this->renderer->addAttribute('list', $list);
        return $this->renderer->render($response, 'devices/list.php');
    }

    public function detail(ServerRequestInterface $request, ResponseInterface $response, $params): ResponseInterface {
        $user = $this->session->get('user');
        if ($user["role"] != "admin") {
            $routeParser = RouteContext::fromRequest($request)->getRouteParser();
            return $response->withStatus(403)->withHeader('Location', $routeParser->urlFor('dashboard'));
        }
        $detail = $this->deviceModel->getDevice((int)$params["id"]);

        $this->renderer->addAttribute('user', $user);
        $this->renderer->addAttribute('detail', $detail);
        $this->renderer->addAttribute('greenhouse', $this->greenhouse);
        return $this->renderer->render($response, 'devices/detail.php');
    }

    public function new(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface {
        $user = $this->session->get('user');
        if ($user["role"] != "admin") {
            $routeParser = RouteContext::fromRequest($request)->getRouteParser();
            return $response->withStatus(403)->withHeader('Location', $routeParser->urlFor('dashboard'));
        }

        $this->renderer->addAttribute('user', $user);
        $this->renderer->addAttribute('detail', []);
        $this->renderer->addAttribute('greenhouse', $this->greenhouse);
        return $this->renderer->render($response, 'devices/edit.php');
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
        $data["created_by"] = $user["id"];

        // Invoke the Domain with inputs and retain the result
        $device = $this->deviceModel->createDevice($data);

        if (!isset($device["id"])) {
            $this->renderer->addAttribute('user', $user);
            $this->renderer->addAttribute('detail', $data);
            $this->renderer->addAttribute('greenhouse', $this->greenhouse);
            return $this->renderer->render($response, 'devices/edit.php');
        }

        $routeParser = RouteContext::fromRequest($request)->getRouteParser();
        return $response->withStatus(403)->withHeader('Location', $routeParser->urlFor('devices-detail', ["id" => $device["id"]]));
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
        $detail = $this->deviceModel->updateDevice($data);

        $this->renderer->addAttribute('user', $user);
        $this->renderer->addAttribute('detail', $detail);
        $this->renderer->addAttribute('greenhouse', $this->greenhouse);
        return $this->renderer->render($response, 'devices/detail.php');
    }

    public function delete(ServerRequestInterface $request, ResponseInterface $response, $id): ResponseInterface {
        $user = $this->session->get('user');
        if ($user["role"] != "admin") {
            $routeParser = RouteContext::fromRequest($request)->getRouteParser();
            return $response->withStatus(403)->withHeader('Location', $routeParser->urlFor('dashboard'));
        }
        $this->deviceModel->deleteDevice($id);

        $this->renderer->addAttribute('user', $user);
        return $this->renderer->render($response, 'devices/list.php');
    }
}