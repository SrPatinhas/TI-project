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
    /*
     * Routes for Authentication
     */
    // homepage in case of being logged in
    $app->get('/', \App\Action\HomeAction::class . ":home")->setName('home');
    //login page
    $app->get('/login', \App\Action\LoginAction::class . ":login")->setName('login');
    // validates and creates a new session based in the data received from the login form
    $app->post('/login', \App\Action\LoginAction::class . ":loginCheck")->setName('loginPost');
    // removes teh session
    $app->get('/logout', \App\Action\LoginAction::class . ":logout")->setName('logout');

    /*
     * Run script from Python to save images sent by the script
     */
    $app->get('/security', \App\Action\HomeAction::class . ":getPyFace")->setName('security');
    /*
     * API Routes
     */
    $app->redirect('/api[/]', '/api/v1', 301);
    /*
     * paths of API, based in the Version 1
     */
    $app->group('/api/v1', function (RouteCollectorProxy $group) {
        // returns the version of the API
        $group->get('[/]', \App\Action\ApiAction::class . ":index")->setName('api');
        //returns the last log of the corresponding device based on the name and position
        $group->get('/log/{line}/{position}/{name}', \App\Action\ApiAction::class . ":getLog")->setName('apiLogGet');
        //post a new log from a IoT device
        $group->post('/log[/]', \App\Action\ApiAction::class . ":addLog")->setName('apiLogAdd');
        // receives an image from the python script
        $group->post('/security', \App\Action\ApiAction::class . ":addSecurity")->setName('apiSecurity');
    });

    /*
     * Dashboard Routes
     */
    // show a list/grid of webcams
    $app->get('/webcams', \App\Action\HomeAction::class . ":webcams")->setName('webcams')->add(UserAuthMiddleware::class);
    // detail of a device, with all of the information available, including logs
    $app->get('/device/view/{id}', \App\Action\DevicesAction::class . ":view")->setName('deviceView')->add(UserAuthMiddleware::class);
    // detail of a plant, with all of the information available, including logs
    $app->get('/plant/view/{id}', \App\Action\PlantsAction::class . ":view")->setName('plantView')->add(UserAuthMiddleware::class);
    // list of logs
    $app->get('/logs[/]', \App\Action\LogsAction::class . ":index")->setName('logIndex')->add(UserAuthMiddleware::class);
    // list of logs from a device
    $app->get('/logs/device/{id}', \App\Action\LogsAction::class . ":chartByDevice")->setName('chartByDevice')->add(UserAuthMiddleware::class);
    // list of logs for a plant, based on the position, it will get all the logs from any device in the line and position given
    $app->get('/logs/plant/{line}/{position}', \App\Action\LogsAction::class . ":chartByPlant")->setName('chartByPlant')->add(UserAuthMiddleware::class);

    /*
     * Request for dynamic updated content in dashboard page (ajax refresh on Dashboard page)
     */
    $app->get('/refresh-list/devices', \App\Action\HomeAction::class . ":refreshDevices")->setName('refreshDevices')->add(UserAuthMiddleware::class);
    $app->get('/refresh-list/plants', \App\Action\HomeAction::class . ":refreshPlants")->setName('refreshPlants')->add(UserAuthMiddleware::class);


    // Dashboard page
    $app->get('/dashboard[/]', \App\Action\HomeAction::class . ":dashboard")->setName('dashboard')->add(UserAuthMiddleware::class);

    /*
     * all pages related to a device
     */
    $app->group('/devices', function (RouteCollectorProxy $group) {
        // list of devices
        $group->get('', \App\Action\DevicesAction::class . ":index")->setName('devices');
        $group->get('/', \App\Action\DevicesAction::class . ":index");
        //detail of a device
        $group->get('/detail/{id}', \App\Action\DevicesAction::class . ":detail")->setName('devices-detail');
        //edit a device
        $group->get('/edit/{id}', \App\Action\DevicesAction::class . ":edit");
        // new device
        $group->get('/new', \App\Action\DevicesAction::class . ":new");
        // post return from a "/new" page, with the data from a form
        $group->post('/create', \App\Action\DevicesAction::class . ":create");
        //update a device
        $group->post('/update', \App\Action\DevicesAction::class . ":update");
        //delete a device
        $group->get('/delete/{id}', \App\Action\DevicesAction::class . ":delete");
        //Update a single field
        $group->get('/update/{id}/{field}', \App\Action\DevicesAction::class . ":updateField");
    })->add(UserAuthMiddleware::class);

    $app->group('/plants', function (RouteCollectorProxy $group) {
        //list of plants
        $group->get('', \App\Action\PlantsAction::class . ":index")->setName('plants');
        $group->get('/', \App\Action\PlantsAction::class . ":index");
        //detail of a plant
        $group->get('/detail/{id}', \App\Action\PlantsAction::class . ":detail")->setName('plants-detail');
        //edit a plant
        $group->get('/edit/{id}', \App\Action\PlantsAction::class . ":edit");
        // new plant
        $group->get('/new', \App\Action\PlantsAction::class . ":new");
        // post return from a "/new" page, with the data from a form
        $group->post('/create', \App\Action\PlantsAction::class . ":create");
        //update a plant
        $group->post('/update', \App\Action\PlantsAction::class . ":update");
        //delete a plant
        $group->get('/delete/{id}', \App\Action\PlantsAction::class . ":delete");
    })->add(UserAuthMiddleware::class);

    $app->group('/users', function (RouteCollectorProxy $group) {
        //list of users
        $group->get('', \App\Action\UserAction::class . ":index")->setName('users');
        $group->get('/', \App\Action\UserAction::class . ":index");
        //detail of a user
        $group->get('/detail/{id}', \App\Action\UserAction::class . ":detail")->setName('users-detail');
        //edit a user
        $group->get('/edit/{id}', \App\Action\UserAction::class . ":edit");
        // new user
        $group->get('/new', \App\Action\UserAction::class . ":new");
        // post return from a "/new" page, with the data from a form
        $group->post('/create', \App\Action\UserAction::class . ":create");
        //update a user
        $group->post('/update', \App\Action\UserAction::class . ":update");
        //delete a user
        $group->get('/delete/{id}', \App\Action\UserAction::class . ":delete");
    })->add(UserAuthMiddleware::class);

    /*
     * Paths for the upload of any file in the plants group
     */
    $app->get('/filepond', \App\Action\Files\FilePondIndexAction::class);
    $app->post('/filepond/process', \App\Action\Files\FilePondProcessAction::class);
    $app->delete('/filepond/revert', \App\Action\Files\FilePondRevertAction::class);
};
