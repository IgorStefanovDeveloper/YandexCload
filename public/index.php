<?php

use Controllers\DataController;
use Controllers\RestController;
use Laminas\Diactoros\ServerRequestFactory;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

require_once __DIR__ . "/../vendor/autoload.php";

error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . "/../");
$dotenv->load();

$loader = new FilesystemLoader(__DIR__ . '/../view');
$view = new Environment($loader);

$app = AppFactory::create();

$queryData = ServerRequestFactory::fromGlobals()->getQueryParams();

$app->get('/', function (Request $request, Response $response, $args) use ($view) {
    $dataProvider = new DataController();

    $data = $dataProvider->getDataForAuthPage();

    $body = $view->render($data['template'], [
        'title' => $data['title'],
        'providersList' => $data['providersList']
    ]);

    $response->getBody()->write($body);

    return $response;
});

$app->get('/provider/{provider}', function (Request $request, Response $response, $args) use ($view, $queryData) {
    $dataProvider = new DataController();

    $data = $dataProvider->getDataForContentPage($queryData, $args);

    $body = $view->render($data['template'], $data);

    $response->getBody()->write($body);

    return $response;
});

$app->map(['GET', 'POST'], '/provider/{provider}/action/{action}', function (Request $request, Response $response, $args) use ($view, $queryData) {
    $dataProvider = new DataController();

    $data = $dataProvider->getDataForAjax($queryData, $args);

    if($data['needReload']){
        $body = $view->render($data['template'], $data);
    }else{
        $body = $data['content'];
    }

    $response->getBody()->write($body);

    return $response;
});

$app->map(['GET', 'POST'], '/api/{provider}/{action}', function (Request $request, Response $response, $args) {
    $rest = new RestController();

    $data = $rest->getDataForApiRequest($request, $args);

    $response->getBody()->write($data);

    return $response
        ->withHeader('Content-Type', 'application/json');
});

$app->run();