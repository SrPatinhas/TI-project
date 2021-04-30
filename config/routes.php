<?php
/**
 * Created by PhpStorm.
 * Project: TI
 * User: Miguel Cerejo
 * Date: 4/25/2021
 * Time: 3:33 PM
 *
 * File: routes.php
 */

use Slim\App;
use App\Middleware\UserAuthMiddleware;
use Slim\Routing\RouteCollectorProxy;

return function (App $app) {
    $app->get('/', \App\Action\HomeAction::class . ":home")->setName('home');
    $app->get('/login', \App\Action\LoginAction::class . ":login")->setName('login');
    $app->post('/login', \App\Action\LoginAction::class . ":loginCheck")->setName('loginPost');
    $app->get('/logout', \App\Action\LoginAction::class . ":logout")->setName('logout');

    $app->redirect('/api[/]', '/api/v1', 301);

    $app->group('/api/v1', function (RouteCollectorProxy $group) {
        $group->get('', \App\Action\ApiAction::class . ":index")->setName('api');
        $group->get('/', \App\Action\ApiAction::class . ":index");
        $group->post('/log/{device}', \App\Action\ApiAction::class . ":device")->setName('apiDevice');
    })->add(UserAuthMiddleware::class);

    // Password protected area
    $app->group('/dashboard', function (RouteCollectorProxy $group) {
        $group->get('', \App\Action\HomeAction::class . ":dashboard")->setName('dashboard');
        $group->get('/', \App\Action\HomeAction::class . ":dashboard");
        $group->get('/logs/{device}', \App\Action\UserAction::class);
    })->add(UserAuthMiddleware::class);


    $app->group('/devices', function (RouteCollectorProxy $group) {
        $group->get('', \App\Action\DevicesAction::class . ":index")->setName('devices');
        $group->get('/', \App\Action\DevicesAction::class . ":index");
        $group->get('/detail/{id}', \App\Action\DevicesAction::class . ":detail")->setName('devices-detail');
        $group->get('/edit/{id}', \App\Action\DevicesAction::class . ":edit");
        $group->get('/new', \App\Action\DevicesAction::class . ":new");
        $group->post('/create', \App\Action\DevicesAction::class . ":create");
        $group->post('/update', \App\Action\DevicesAction::class . ":update");
        $group->get('/delete/{id}', \App\Action\DevicesAction::class . ":delete");
    })->add(UserAuthMiddleware::class);

    $app->group('/plants', function (RouteCollectorProxy $group) {
        $group->get('', \App\Action\PlantsAction::class . ":index")->setName('devices');
        $group->get('/', \App\Action\PlantsAction::class . ":index");
        $group->get('/detail/{id}', \App\Action\PlantsAction::class . ":detail")->setName('plants-detail');
        $group->get('/edit/{id}', \App\Action\PlantsAction::class . ":edit");
        $group->get('/new', \App\Action\PlantsAction::class . ":new");
        $group->post('/create', \App\Action\PlantsAction::class . ":create");
        $group->post('/update', \App\Action\PlantsAction::class . ":update");
        $group->get('/delete/{id}', \App\Action\PlantsAction::class . ":delete");
    })->add(UserAuthMiddleware::class);

    $app->group('/users', function (RouteCollectorProxy $group) {
        $group->get('', \App\Action\UserAction::class . ":index")->setName('users');
        $group->get('/', \App\Action\UserAction::class . ":index");
        $group->get('/detail/{id}', \App\Action\UserAction::class . ":detail");
        $group->get('/edit/{id}', \App\Action\UserAction::class . ":edit");
        $group->get('/new', \App\Action\UserAction::class . ":new");
        $group->post('/create', \App\Action\UserAction::class . ":create");
        $group->post('/update', \App\Action\UserAction::class . ":update");
        $group->get('/delete/{id}', \App\Action\UserAction::class . ":delete");
    })->add(UserAuthMiddleware::class);

    $app->get('/filepond', \App\Action\Files\FilePondIndexAction::class);
    $app->post('/filepond/process', \App\Action\Files\FilePondProcessAction::class);
    $app->delete('/filepond/revert', \App\Action\Files\FilePondRevertAction::class);
};
