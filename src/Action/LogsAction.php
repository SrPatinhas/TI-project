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
        if ($this->userSession["role"] == "user") {
            $list = $this->logModel->getLogByUser($this->userSession["id"]);
        } else {
            $list = $this->logModel->getLogsList();
        }

        $this->renderer->addAttribute('list', $list);
        return $this->renderer->render($response, 'logs/list.php');
    }



    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     * @throws \Throwable
     */
    public function chartByPlant(ServerRequestInterface $request, ResponseInterface $response, $params): ResponseInterface {
        $list = $this->logModel->getLogByPlant($params["line"], $params["position"]);

        $this->renderer->addAttribute('list', $list);
        return $this->renderer->render($response, 'logs/list.php');
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param $params
     * @return ResponseInterface
     */
    public function chartByDevice(ServerRequestInterface $request, ResponseInterface $response, $params): ResponseInterface {
        $list = $this->logModel->getLogByDevice($params["id"], true);

        $info = chart_format($list);

        // Build the HTTP response
        $response->getBody()->write((string)json_encode($info));

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(201);
    }
}