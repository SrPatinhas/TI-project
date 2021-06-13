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

use App\Domain\Log\Service\Log;
use Odan\Session\SessionInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\PhpRenderer;

final class LogsAction
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
     * @var Log
     */
    private $logModel;

    /**
     * @var mixed|null
     */
    private $userSession;

    /**
     * LogsAction constructor.
     * @param Log $logModel
     * @param PhpRenderer $renderer
     * @param SessionInterface $session
     */
    public function __construct(Log $logModel, PhpRenderer $renderer, SessionInterface $session)
    {
        //initiates all the variables that will be needed in the functions
        $this->renderer = $renderer;
        $this->session = $session;
        $this->logModel = $logModel;

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
        //validates if is just a user, and returns the logs to the positions of his plants
        if ($this->userSession["role"] == "user") {
            $list = $this->logModel->getLogByUser($this->userSession["id"]);
        } else {
            // or else will return all the logs in a list
            $list = $this->logModel->getLogsList();
        }

        //adds the variables to the renderer function so we can use it in the template page
        $this->renderer->addAttribute('list', $list);
        // returns the page that we want to render
        return $this->renderer->render($response, 'logs/list.php');
    }



    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     * @throws \Throwable
     */
    public function chartByPlant(ServerRequestInterface $request, ResponseInterface $response, $params): ResponseInterface {
        // returns a list of logs by a position and line
        $list = $this->logModel->getLogByPlant($params["line"], $params["position"]);

        //adds the variables to the renderer function so we can use it in the template page
        $this->renderer->addAttribute('list', $list);
        // returns the page that we want to render
        return $this->renderer->render($response, 'logs/list.php');
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param $params
     * @return ResponseInterface
     */
    public function chartByDevice(ServerRequestInterface $request, ResponseInterface $response, $params): ResponseInterface {
        //gets a list of logs from a device
        $list = $this->logModel->getLogByDevice($params["id"], true);
        // formats the list in a chartJs format to be returned by json
        $info = chart_format($list);

        // Build the HTTP response
        $response->getBody()->write((string)json_encode($info));

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(201);
    }
}