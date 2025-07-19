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

/* Détection du workspace actif */
$workspace = WorkspaceDetector::detect();
Container::getInstance()->set( 'workspace', $workspace );

/* Calcul des chemins dynamiquement selon le workspace actif */
$wsBase         = is_dir( __DIR__ . "/../workspaces/$workspace" ) ? __DIR__ . "/../workspaces/$workspace" : __DIR__ . '/../app';
$wsControllers  = $wsBase . "/Controllers";
$wsViews        = $wsBase . "/Views";

/* Initialisation de TwigService */
$twigService    = new TwigService( $wsViews );
$twig           = $twigService->getTwig();
Container::getInstance()->set( 'twig', $twig ); 

/* Chargement des modules "Autorisés/Activés" uniquement */

/* 1. Modules globaux (racine) */
$globalModules = [];
if( file_exists( __DIR__ . '/../config/modules.php' ) ){
    $globalModules = require __DIR__ . '/../config/modules.php';
}

foreach( $globalModules as $modName ){
    $reg = __DIR__ . '/../modules/' . $modName . '/register.php';
    if( file_exists( $reg ) ){
        require $reg;
    }
}

/* 2. Modules spécifiques workspace */
$workspaceModules = [];
if( file_exists( $wsBase . '/modules.php' ) ){
    $workspaceModules . '/modules/' . $modName . '/register.php';
    if( file_exists( $reg ) ) require $reg;
}

/* Affichage de la page Welcome si aucun contrôleur métier */
$hasControllers = !empty( glob( $wsControllers . '/*.php' ) );
$isDefault      = ( $workspace === 'default' || $workspace === '' || $workspace === null );
if( !$hasControllers && $isDefault ){
    echo $twig->render( 'welcome.html.twig' );
    exit;
}

/* Exécution du pipeline middlewares (si loader dispo) */
$corelia_middleware_loader = $_GLOBALS['corelia_middlewares'][ $wsBase ] ?? null;
if( $corelia_middleware_loader ){

    $runner = $corelia_middleware_loader();
    $resp   = $runner->handle( $_REQUEST, function( $request ) use ( $wsControllers ) {
        $router = new Router( $wsControllers );
        ob_start();

            $router->dispatch( $_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD'] );
        
        $output = ob_get_clean();

        if( $output ) return new \Corelia\Http\Response( $output );
    }); 

    if( $resp instanceof \Corelia\Http\Response ) $resp->send();
    else{
        $router = new Router( $wsControllers );
        $router->dispatch( $_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD'] );
    }

}