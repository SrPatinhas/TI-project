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

use App\Domain\Device\Service\Device;
use App\Domain\Log\Service\Log;
use App\Domain\Plant\Service\Plant;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Routing\RouteContext;
use Slim\Views\PhpRenderer;
use Odan\Session\SessionInterface;

final class HomeAction
{
    /**
     * @var PhpRenderer
     */
    private $renderer;
    /**
     * @var SessionInterface
     */
    private $session;

    private $plantModel;

    private $deviceModel;

    private $userSession;

    private $logModel;

    public function __construct(PhpRenderer $renderer, SessionInterface $session, Log $logModel, Plant $plantModel, Device $deviceModel)
    {
        $this->renderer = $renderer;
        $this->session = $session;
        $this->plantModel = $plantModel;
        $this->deviceModel = $deviceModel;
        $this->logModel = $logModel;

        // Get user logged on and share it to the page
        $this->userSession = $this->session->get('user');
        $this->renderer->addAttribute('user', $this->userSession);
    }

    public function home(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface {
        // Get RouteParser from request to generate the urls
        $routeParser = RouteContext::fromRequest($request)->getRouteParser();
        if ($this->userSession) {
            return $response->withStatus(302)->withHeader('Location', $routeParser->urlFor('dashboard'));
        }
        return $response->withStatus(302)->withHeader('Location', $routeParser->urlFor('login'));
    }

    public function dashboard(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface {
        if ($this->userSession["role"] == "user") {
            $plants = $this->plantModel->getPlantsListByUser($this->userSession["id"]);
        } else {
            $plants = $this->plantModel->getPlantsList();
            $devices = $this->deviceModel->getDevicesList();
            $this->renderer->addAttribute('devices', $devices);
        }
        foreach ($plants as $key => $item) {
            $plants[$key]["log"] = $this->logModel->getLastLog($item["line"], $item["position"]);
        }

        $this->renderer->addAttribute('plants', $plants);
        return $this->renderer->render($response, 'dashboard.php');
    }

    public function webcams(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface {
        if ($this->userSession["role"] != "admin") {
            // Get RouteParser from request to generate the urls
            $routeParser = RouteContext::fromRequest($request)->getRouteParser();
            return $response->withStatus(403)->withHeader('Location', $routeParser->urlFor('dashboard'));
        }

        $webcams = $this->plantModel->getWebcamsList();

        $this->renderer->addAttribute('webcams', $webcams);
        return $this->renderer->render($response, 'webcams.php');
    }

    public function refreshDevices(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface {
        if ($this->userSession["role"] != "user") {
            $devices = $this->deviceModel->getDevicesList();
            $this->renderer->addAttribute('devices', $devices);
        }

        return $this->renderer->render($response, 'components/refresh-list-devices.php');
    }

    public function refreshPlants(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface {
        if ($this->userSession["role"] == "user") {
            $plants = $this->plantModel->getPlantsListByUser($this->userSession["id"]);
        } else {
            $plants = $this->plantModel->getPlantsList();
        }
        foreach ($plants as $key => $item) {
            $plants[$key]["log"] = $this->logModel->getLastLog($item["line"], $item["position"]);
        }

        $this->renderer->addAttribute('plants', $plants);
        return $this->renderer->render($response, 'components/refresh-list-plants.php');
    }


}
