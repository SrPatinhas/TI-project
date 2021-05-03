<?php
/**
 * Created by PhpStorm.
 * Project: TI
 * User: Miguel Cerejo
 * Date: 4/25/2021
 * Time: 3:34 PM
 *
 * File: middleware.php
 */

use Slim\App;
use Slim\Middleware\ErrorMiddleware;
use Selective\BasePath\BasePathMiddleware;
use App\Middleware\PhpViewExtensionMiddleware;
use Odan\Session\Middleware\SessionMiddleware;
use App\Middleware\HttpExceptionMiddleware;
use App\Middleware\ErrorHandlerMiddleware;

return function (App $app) {
    // Start the session
    $app->add(SessionMiddleware::class);

    // Parse json, form data and xml
    $app->addBodyParsingMiddleware();

    // Add the Slim built-in routing middleware
    $app->addRoutingMiddleware();

    // Set the base path to prevent return 404 in the index page
    $app->add(BasePathMiddleware::class);

    // Dynamic error handler
    $app->add(HttpExceptionMiddleware::class);
    $app->add(ErrorHandlerMiddleware::class);

    // log errors in file
    $loggerFactory = $app->getContainer()->get(\App\Factory\LoggerFactory::class);
    $logger = $loggerFactory->addFileHandler('error.log')->createLogger();

    $errorMiddleware = $app->addErrorMiddleware(true, true, true, $logger);
    // Catch exceptions and errors
    $app->add(ErrorMiddleware::class);

    // Middleware for the views
    $app->add(PhpViewExtensionMiddleware::class);
};
