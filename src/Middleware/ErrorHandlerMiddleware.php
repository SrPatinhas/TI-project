<?php
/**
 * Created by PhpStorm.
 * Project: TI
 * User: Miguel Cerejo
 * Date: 4/27/2021
 * Time: 3:25 AM
 *
 * File: ErrorHandlerMiddleware.php
 */

namespace App\Middleware;

use App\Factory\LoggerFactory;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Log\LoggerInterface;

/**
 * Middleware.
 */
final class ErrorHandlerMiddleware implements MiddlewareInterface
{
    /**
     * @var LoggerInterface
     */
    private $logger;


    /**
     * The constructor.
     *
     * @param LoggerFactory $loggerFactory The logger
     */
    public function __construct(LoggerFactory $loggerFactory)
    {
        $this->logger = $loggerFactory
            ->addFileHandler('errors.log')
            ->createLogger();
    }

    /**
     * Invoke middleware.
     *
     * @param ServerRequestInterface $request The request
     * @param RequestHandlerInterface $handler The handler
     *
     * @return ResponseInterface The response
     */
    public function process(
        ServerRequestInterface $request,
        RequestHandlerInterface $handler
    ): ResponseInterface
    {
        $errorTypes = E_ALL;

        // Set custom php error handler
        set_error_handler(
            function ($errno, $errstr, $errfile, $errline) {
                switch ($errno) {
                    case E_USER_ERROR:
                        $this->logger->error(
                            "Error number [$errno] $errstr on line $errline in file $errfile"
                        );
                        break;
                    case E_USER_WARNING:
                        $this->logger->warning(
                            "Error number [$errno] $errstr on line $errline in file $errfile"
                        );
                        break;
                    default:
                        $this->logger->notice(
                            "Error number [$errno] $errstr on line $errline in file $errfile"
                        );
                        break;
                }

                // Don't execute PHP internal error handler
                return true;
            },
            $errorTypes
        );

        return $handler->handle($request);
    }
}