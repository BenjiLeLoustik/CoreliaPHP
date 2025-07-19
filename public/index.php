<?php

/* ===== ./public/index.php ===== */

require_once __DIR__ . '/../vendor/autoload.php';

use Corelia\Bootstrap\Bootstrap;
use Corelia\Routing\Router;
use Corelia\View\TwigService;
use Corelia\Config\Container;

Bootstrap::init();

/* Initialisation de TwigService */
$viewsPath      = __DIR__ . '/../app/Views';
$twigService    = new TwigService( $viewsPath );
Container::getInstance()->set( 'twig', $twigService->getTwig() ); 

$router = new Router( __DIR__ . '/../app/Controllers' );
$router->dispatch( $_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD'] );
