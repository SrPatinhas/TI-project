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

    private $logModel;

    public function __construct(Log $logModel, PhpRenderer $renderer, SessionInterface $session)
    {
        $this->renderer = $renderer;
        $this->session = $session;
        $this->logModel = $logModel;
    }

    public function index(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface {
        $user = $this->session->get('user');
        if ($user["role"] == "user") {
            $list = $this->logModel->getLogByUser($user["id"]);
        } else {
            $list = $this->logModel->getLogsList();
        }


        $this->renderer->addAttribute('user', $user);
        $this->renderer->addAttribute('list', $list);
        return $this->renderer->render($response, 'logs/list.php');
    }

    public function view(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface {
        $user = $this->session->get('user');

        $detail = $this->logModel->getUser($data["userid"], $data["email"]);

        $this->renderer->addAttribute('user', $user);
        $this->renderer->addAttribute('detail', $detail);
        return $this->renderer->render($response, 'users/detail.php');
    }

}