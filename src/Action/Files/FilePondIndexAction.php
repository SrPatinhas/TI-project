<?php
/**
 * Created by PhpStorm.
 * Project: TI
 * User: Miguel Cerejo
 * Date: 4/27/2021
 * Time: 7:15 PM
 *
 * File: FilePondIndexAction.php
 */

namespace App\Action\Files;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class FilePondIndexAction
{
    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response
    ): ResponseInterface {
        $template = __DIR__ . '/../../../templates/filepond.html';
        $response->getBody()->write(file_get_contents($template));

        return $response;
    }
}