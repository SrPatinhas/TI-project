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
        //initiates all the variables that will be needed in the functions
        $this->renderer = $renderer;
        $this->plantModel = $plantModel;
        $this->session = $session;
        $this->logModel = $logModel;
        $this->greenhouse = $container->get('greenhouse');

        // Get user logged on and share it to the page
        $this->userSession = $this->session->get('user');
        $this->renderer->addAttribute('user', $this->userSession);
        //add the "greenhouse" variable to every response
        $this->renderer->addAttribute('greenhouse', $this->greenhouse);
    }


    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     * @throws \Throwable
     */
    public function index(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface {
        //validates if is a user and returns only a list of his plants
        if ($this->userSession["role"] == "user") {
            $list = $this->plantModel->getPlantsListByUser($this->userSession["id"]);
        } else {
            // or else will return all the plants
            $list = $this->plantModel->getPlantsList();
        }

        //adds the variables to the renderer function so we can use it in the template page
        $this->renderer->addAttribute('list', $list);
        // returns the page that we want to render
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
        // get the requested plant
        $detail = $this->plantModel->getPlant((int)$params["id"]);
        // gets all the logs associated to the position of the requested plant
        $logs = $this->logModel->getLogByPlant($detail["line"], $detail["position"]);

        //adds the variables to the renderer function so we can use it in the template page
        $this->renderer->addAttribute('detail', $detail);
        $this->renderer->addAttribute('logs', $logs);

        // Get last logs for this device
        $chart_logs = $this->logModel->getLogByPlant($detail["line"], $detail["position"], true);
        // create Chart object with correct data and split with labels
        $info = chart_format($chart_logs);
        //adds the variables to the renderer function so we can use it in the template page
        $this->renderer->addAttribute('datasets', $info["list"]);
        $this->renderer->addAttribute('labels', $info["label"]);

        // returns the page that we want to render
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
        // get the requested plant
        $detail = $this->plantModel->getPlant((int)$params["id"]);
        //adds the variables to the renderer function so we can use it in the template page
        $this->renderer->addAttribute('detail', $detail);
        // returns the page that we want to render
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
        // get the requested plant
        $detail = $this->plantModel->getPlant((int)$params["id"]);
        //adds the variables to the renderer function so we can use it in the template page
        $this->renderer->addAttribute('detail', $detail);
        // returns the page that we want to render
        return $this->renderer->render($response, 'plants/edit.php');
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     * @throws \Throwable
     */
    public function new(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface {
        // returns a empty array, so we prevent any runtime error
        //adds the variable to the response, so we can use it in the template
        $this->renderer->addAttribute('detail', []);
        // returns the page that we want to render
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
        // gets the user id of the creator to associate the plant to a user
        $data["created_by"] = $this->userSession["id"];
        //splits the response given by the form, to get the position and the line in separated fields
        $grid = explode("-", $data["grid-position"]);
        $data["line"] = $grid[0];
        $data["position"] = $grid[1];

        // Invoke the Domain with inputs and retain the result
        $plant = $this->plantModel->createPlant($data);
        // if everything is ok, it will return to the edit page of the plant
        if (!isset($plant["id"])) {
            $this->renderer->addAttribute('detail', $data);
            return $this->renderer->render($response, 'plants/edit.php');
        }
        //if not, will return to the creation page with the error to be able to change and save after
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

        //splits the response given by the form, to get the position and the line in separated fields
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
        //validates if the user has permissions to see the requested page
        if ($this->userSession["role"] != "admin") {
            return $response->withStatus(403)->withHeader('Location', $routeParser->urlFor('dashboard'));
        }
        //deletes the plant with the given ID
        $this->plantModel->deletePlant($params['id']);
        return $response->withStatus(403)->withHeader('Location', $routeParser->urlFor('plants'));
    }
}