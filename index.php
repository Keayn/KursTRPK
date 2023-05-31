<?php
// подключаем пакеты которые установили через composer
require_once '../vendor/autoload.php';
require_once '../framework/autoload.php';
require_once '../controllers/Controller404.php';
require_once '../controllers/MainController.php';
require_once '../controllers/ObjectController.php';
require_once '../controllers/SearchController.php';
require_once '../controllers/PCCreateController.php';
require_once '../controllers/PCTypesCreateController.php';
require_once '../controllers/PCDeleteController.php';
require_once '../controllers/PCUpdateController.php';
require_once '../controllers/LoginController.php';
require_once '../controllers/LogoutController.php';
require_once '../controllers/DNSkorzina.php';

require_once '../middlewares/LoginRequiredMiddleware.php';
require_once '../middlewares/HistoryMiddleware.php';
$loader = new \Twig\Loader\FilesystemLoader('../views');
$twig = new \Twig\Environment($loader, [
        "debug" => true
]);
$twig->addExtension(new \Twig\Extension\DebugExtension());

$pdo = new PDO("mysql:host=localhost;dbname=outer_pc;charset=utf8", "root", "");

session_set_cookie_params(60 * 60 * 10);
session_start();

$router = new Router($twig, $pdo);
$router->add("/", MainController::class)
        ->middleware(new HistoryMiddleware());
$router->add("/pc_objects/(?P<id>\d+)(\?show=(?P<section>\w+))?", ObjectController::class)
        ->middleware(new HistoryMiddleware());
$router->add("/search", SearchController::class)
        ->middleware(new HistoryMiddleware());
$router->add("/pc_objects/create", PCCreateController::class)
        ->middleware(new LoginRequiredMiddleware())
        ->middleware(new HistoryMiddleware());
$router->add("/create_type", PCTypesCreateController::class)
        ->middleware(new LoginRequiredMiddleware())
        ->middleware(new HistoryMiddleware());
$router->add("/pc_objects/(?P<id>\d+)/delete", PCDeleteController::class)
        ->middleware(new LoginRequiredMiddleware())
        ->middleware(new HistoryMiddleware());
$router->add("/pc_objects/(?P<id>\d+)/update", PCUpdateController::class)
        ->middleware(new LoginRequiredMiddleware())
        ->middleware(new HistoryMiddleware());
$router->add("/login", LoginController::class)
        ->middleware(new HistoryMiddleware());
$router->add("/logout", LogoutController::class);

$router->add("/korzina", DNSkorzina::class)
        ->middleware(new HistoryMiddleware());

$router->get_or_default(Controller404::class);
