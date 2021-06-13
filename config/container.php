<?php
/**
 * Created by PhpStorm.
 * Project: TI
 * User: Miguel Cerejo
 * Date: 4/25/2021
 * Time: 3:34 PM
 *
 * File: container.php
 */

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Slim\Views\PhpRenderer;
use Slim\App;
use Slim\Factory\AppFactory;
use Slim\Middleware\ErrorMiddleware;
use Selective\BasePath\BasePathMiddleware;
use Odan\Session\PhpSession;
use Odan\Session\SessionInterface;
use Odan\Session\Middleware\SessionMiddleware;
use App\Factory\LoggerFactory;

return [
    'settings' => function () {
        return require __DIR__ . '/settings.php';
    },

    'greenhouse' => function (ContainerInterface $container) {
        $settings = $container->get('settings');
        return $settings['greenhouse'];
    },

    SessionInterface::class => function (ContainerInterface $container) {
        // load settings for any needed config in the app
        $settings = $container->get('settings');
        $session = new PhpSession();
        $session->setOptions((array)$settings['session']);

        return $session;
    },

    SessionMiddleware::class => function (ContainerInterface $container) {
        return new SessionMiddleware($container->get(SessionInterface::class));
    },

    App::class => function (ContainerInterface $container) {
        AppFactory::setContainer($container);

        return AppFactory::create();
    },


    ResponseFactoryInterface::class => function (ContainerInterface $container) {
        return $container->get(App::class)->getResponseFactory();
    },
    /*
     * log any errors that  occurred
     */
    ErrorMiddleware::class => function (ContainerInterface $container) {
        $app = $container->get(App::class);
        $settings = $container->get('settings')['error'];

        return new ErrorMiddleware(
            $app->getCallableResolver(),
            $app->getResponseFactory(),
            (bool)$settings['display_error_details'],
            (bool)$settings['log_errors'],
            (bool)$settings['log_error_details']
        );
    },

    BasePathMiddleware::class => function (ContainerInterface $container) {
        return new BasePathMiddleware($container->get(App::class));
    },
    /*
     * Loader of the mysql connection
     */
    PDO::class => function (ContainerInterface $container) {
        $settings = $container->get('settings')['db'];

        $host = $settings['host'];
        $dbname = $settings['database'];
        $username = $settings['username'];
        $password = $settings['password'];
        $charset = $settings['charset'];
        $flags = $settings['flags'];
        $dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";

        return new PDO($dsn, $username, $password, $flags);
    },

    /*
     * start the engine of the template render
     */
    PhpRenderer::class => function (ContainerInterface $container) {
        return new PhpRenderer($container->get('settings')['view']['path']);
    },

    /*
     * starter for the logger in the app to log in the file in any error occurred
     */
    LoggerFactory::class => function (ContainerInterface $container) {
        return new LoggerFactory($container->get('settings')['logger']);
    },
];
