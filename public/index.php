<?php

/* ===== ./public/index.php ===== */

require_once __DIR__ . '/../vendor/autoload.php';

use Corelia\Bootstrap\Bootstrap;
use Corelia\Bootstrap\WorkspaceDetector;
use Corelia\Routing\Router;
use Corelia\View\TwigService;
use Corelia\Config\Container;

Bootstrap::init();

$workspace = WorkspaceDetector::detect();
Container::getInstance()->set( 'workspace', $workspace );

/* Paths dynamiques selon le workspace actif */
$workspaceControllers   = __DIR__ . "/../workspaces/{$workspace}/Controllers";
$workspaceViews         = __DIR__ . "/../workspaces/{$workspace}/Views";

/* Fallback : Si pas de dossier workspace spécifique, fallback sur app/ */
if( !is_dir( $workspaceControllers ) ) $workspaceControllers = __DIR__ . '/../app/Controllers';
if( !is_dir( $workspaceViews ) ) $workspaceViews = __DIR__ . '/../app/Views';

/* Initialisation de TwigService */
$twigService    = new TwigService( $workspaceViews );
Container::getInstance()->set( 'twig', $twigService->getTwig() ); 

$router = new Router( $workspaceControllers );
$router->dispatch( $_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD'] );
