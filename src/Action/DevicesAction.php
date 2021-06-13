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
        //initiates all the variables that will be needed in the functions
        $this->renderer = $renderer;
        $this->session = $session;
        $this->deviceModel = $deviceModel;
        $this->logModel = $logModel;
        $this->greenhouse = $container->get('greenhouse');
        //add the "greenhouse" variable to every response
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
        //gets the list of all devices
        $list = $this->deviceModel->getDevicesList();
        //adds the list of devices to the response, so we can use it in the template
        $this->renderer->addAttribute('list', $list);
        // returns the page that we want to render
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
        //validates if the user has permissions to see the requested page
        if ($this->userSession["role"] == "user") {
            $routeParser = RouteContext::fromRequest($request)->getRouteParser();
            return $response->withStatus(403)->withHeader('Location', $routeParser->urlFor('dashboard'));
        }
        //gets the device
        $detail = $this->deviceModel->getDevice((int)$params["id"]);
        //gets the list  of logs associated to the device
        $logs = $this->logModel->getLogByDevice((int)$params["id"]);
        //gets a list of categories
        $categories = $this->deviceModel->getCategoriesList();
        //gets a list of devices, to show the one related to the current device
        $devices = $this->deviceModel->getDevicesList();
        //adds the variables to the renderer function so we can use it in the template page
        $this->renderer->addAttribute('detail', $detail);
        $this->renderer->addAttribute('logs', $logs);
        $this->renderer->addAttribute('categories', $categories);
        $this->renderer->addAttribute('devices', $devices);

        // Get last logs for this device in so we can pass it to the correct format for the chartJs
        $chart_logs = $this->logModel->getLogByDevice($params["id"], true);
        // create Chart object with correct data and split with labels
        $info = chart_format($chart_logs);
        $this->renderer->addAttribute('datasets', $info["list"]);
        $this->renderer->addAttribute('labels', $info["label"]);

        // returns the page that we want to render
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
        //validates if the user has permissions to see the requested page
        if ($this->userSession["role"] == "user") {
            $routeParser = RouteContext::fromRequest($request)->getRouteParser();
            return $response->withStatus(403)->withHeader('Location', $routeParser->urlFor('dashboard'));
        }
        //gets the information of the requested device
        $detail = $this->deviceModel->getDevice((int)$params["id"]);
        //gets a list of categories
        $categories = $this->deviceModel->getCategoriesList();
        //gets a list of devices, to show the one related to the current device
        $devices = $this->deviceModel->getDevicesList();
        //adds the variables to the renderer function so we can use it in the template page
        $this->renderer->addAttribute('detail', $detail);
        $this->renderer->addAttribute('categories', $categories);
        $this->renderer->addAttribute('devices', $devices);
        // returns the page that we want to render
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
        //validates if the user has permissions to see the requested page
        if ($this->userSession["role"] == "user") {
            $routeParser = RouteContext::fromRequest($request)->getRouteParser();
            return $response->withStatus(403)->withHeader('Location', $routeParser->urlFor('dashboard'));
        }

        $detail = $this->deviceModel->getDevice((int)$params["id"]);
        $categories = $this->deviceModel->getCategoriesList();
        //gets a list of devices, to show the one related to the current device
        $devices = $this->deviceModel->getDevicesList();
        //adds the variables to the renderer function so we can use it in the template page
        $this->renderer->addAttribute('detail', $detail);
        $this->renderer->addAttribute('categories', $categories);
        $this->renderer->addAttribute('devices', $devices);
        // returns the page that we want to render
        return $this->renderer->render($response, 'devices/edit.php');
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     * @throws \Throwable
     */
    public function new(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface {
        //validates if the user has permissions to see the requested page
        if ($this->userSession["role"] == "user") {
            $routeParser = RouteContext::fromRequest($request)->getRouteParser();
            return $response->withStatus(403)->withHeader('Location', $routeParser->urlFor('dashboard'));
        }
        //gets a list of categories
        $categories = $this->deviceModel->getCategoriesList();
        //gets a list of devices, to show the one related to the current device
        $devices = $this->deviceModel->getDevicesList();
        //adds the variables to the renderer function so we can use it in the template page
        $this->renderer->addAttribute('detail', []);
        $this->renderer->addAttribute('categories', $categories);
        $this->renderer->addAttribute('devices', $devices);
        // returns the page that we want to render
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
        //splits the response given by the form, to get the position and the line in separated fields
        $grid = explode("-", $data["grid-position"]);
        $data["line"] = $grid[0];
        $data["position"] = $grid[1];

        // Invoke the Domain with inputs and retain the result
        $device = $this->deviceModel->createDevice($data);
        // validates if the device exists
        if (!isset($device["id"])) {
            //gets a list of categories
            $categories = $this->deviceModel->getCategoriesList();
            //adds the variables to the renderer function so we can use it in the template page
            $this->renderer->addAttribute('detail', $data);
            $this->renderer->addAttribute('errors', $device);
            $this->renderer->addAttribute('categories', $categories);
            // returns the page that we want to render
            return $this->renderer->render($response, 'devices/edit.php');
        }
        // redirect to the correct function so we dont need to do duplicated logic
        $routeParser = RouteContext::fromRequest($request)->getRouteParser();
        // redirects to the correct page with parameters
        return $response->withStatus(403)->withHeader('Location', $routeParser->urlFor('devices-detail', ["id" => $device["id"]]));
    }


    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
    public function update(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface {
        //validates if the user has permissions to see the requested page
        if ($this->userSession["role"] == "user") {
            // Get RouteParser from request to generate the urls
            $routeParser = RouteContext::fromRequest($request)->getRouteParser();
            return $response->withStatus(403)->withHeader('Location', $routeParser->urlFor('dashboard'));
        }
        // Collect input from the HTTP request
        $data = (array)$request->getParsedBody();

        //splits the response given by the form, to get the position and the line in separated fields
        $grid = explode("-", $data["grid-position"]);
        $data["line"] = $grid[0];
        $data["position"] = $grid[1];

        // Invoke the Domain with inputs and retain the result
        $detail = $this->deviceModel->updateDevice($data);

        // redirect to the correct function so we dont need to do duplicated logic
        $routeParser = RouteContext::fromRequest($request)->getRouteParser();
        // redirects to the correct page with parameters
        return $response->withStatus(403)->withHeader('Location', $routeParser->urlFor('devices-detail', ["id" => $detail["id"]]));
    }


    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
    public function updateField(ServerRequestInterface $request, ResponseInterface $response, $params): ResponseInterface {
        //validates if the user has permissions to see the requested page
        if ($this->userSession["role"] == "user") {
            // Build the HTTP response
            $response->getBody()->write((string)json_encode(["no permissions"]));

            return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(403);
        }
        // validates if the fields to be updated are status or state, or else will return an error
        if ($params["field"] != "status" && $params["field"] != "state") {
            // Build the HTTP response
            $response->getBody()->write((string)json_encode(["incorrect params"]));

            return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(400);
        }

        $detail = $this->deviceModel->getDevice((int)$params["id"]);

        //creates the object to update
        $update = [
            "field" => ($params["field"] == "status" ? 'is_active' : 'force_on'),
            "value" => !($params["field"] == "status" ? $detail["is_active"] : $detail['force_on']),
            "id" => (int)$params["id"]
        ];
        // Invoke the Domain with inputs and retain the result
        $detail = $this->deviceModel->updateDeviceField($update);
        // Build the HTTP response
        $response->getBody()->write((string)json_encode(["status" => !($params["field"] == "status" ? $detail["is_active"] : $detail['force_on']) ]));
        // returns a json response
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(201);
    }


    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
    public function updateState(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface {
        //validates if the user has permissions to see the requested page
        if ($this->userSession["role"] == "user") {
            // Get RouteParser from request to generate the urls
            $routeParser = RouteContext::fromRequest($request)->getRouteParser();
            return $response->withStatus(403)->withHeader('Location', $routeParser->urlFor('dashboard'));
        }
        // Collect input from the HTTP request
        $data = (array)$request->getParsedBody();

        // Invoke the Domain with inputs and retain the result
        $detail = $this->deviceModel->updateDeviceState($data["id"]);

        // Build the HTTP response
        $response->getBody()->write((string)json_encode($detail));
        // returns a json response
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(201);
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param $id
     * @return ResponseInterface
     */
    public function delete(ServerRequestInterface $request, ResponseInterface $response, $params): ResponseInterface {
        //validates if the user has permissions to see the requested page
        if ($this->userSession["role"] != "admin") {
            $routeParser = RouteContext::fromRequest($request)->getRouteParser();
            return $response->withStatus(403)->withHeader('Location', $routeParser->urlFor('dashboard'));
        }
        $this->deviceModel->deleteDevice($params['id']);

        // redirect to the correct function so we dont need to do duplicated logic
        $routeParser = RouteContext::fromRequest($request)->getRouteParser();
        // redirects to the correct page with parameters
        return $response->withStatus(403)->withHeader('Location', $routeParser->urlFor('devices'));
    }
}