<?php

/* ===== ./public/index.php ===== */

require_once __DIR__ . '/../vendor/autoload.php';

use Corelia\Bootstrap\Bootstrap;
use Corelia\Bootstrap\WorkspaceDetector;
use Corelia\Routing\Router;
use Corelia\View\TwigService;
use Corelia\Config\Container;
use Corelia\Module\ModuleManager;

Bootstrap::init();

$workspace = WorkspaceDetector::detect();
Container::getInstance()->set( 'workspace', $workspace );

/* 3. Calcul des chemins dynamiquement selon le workspace actif */
$wsControllers      = __DIR__ . "/../workspaces/{$workspace}/Controllers";
$wsViews            = __DIR__ . "/../workspaces/{$workspace}/Views";
$wsRoot             = __DIR__ . "/../workspaces/{$workspace}/";

/* Fallback : Si pas de dossier workspace spécifique, fallback sur app/ */
if( !is_dir( $wsControllers ) ) $wsControllers = __DIR__ . '/../app/Controllers';
if( !is_dir( $wsViews ) ) $wsViews = __DIR__ . '/../app/Views';
if( !is_dir( $wsRoot ) ) $wsRoot = __DIR__ . '/../app';

/* 4. Démarrage du système de modules dynamiques */
$modulesDir     = __DIR__ . '/../modules';
$moduleManager  = new ModuleManager( $wsRoot );
$modulesLoaded  = $moduleManager->scanModules( $modulesDir );

/* Activation automatique d'un ou plusieurs modules */
$modulesToActivate = [ 'Middlewares' ];

foreach( $modulesToActivate as $moduleName ){
    $moduleManager->activate( $moduleName );
}

/* Initialisation de TwigService */
$twigService    = new TwigService( $wsViews );
$twig           = $twigService->getTwig();
Container::getInstance()->set( 'twig', $twig ); 

$noControllers  = empty( glob( $wsControllers . '/*.php' ) );
$isDefault      = ( $workspace === 'default' || $workspace === '' || $workspace === null );

/* Si aucun workspace réel, ni contrôleur métier trouvé, rendre la page Welcome */
if( $isDefault && $noControllers ){
    echo $twig->render( 'welcome.html.twig' );
    exit;
}

$router = new Router( $wsControllers );
$router->dispatch( $_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD'] );
