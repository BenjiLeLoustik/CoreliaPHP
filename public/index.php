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
$globalModules = file_exists( __DIR__ . '/../config/modules.php' ) ? require __DIR__ . '/../config/modules.php' : [];
foreach( $globalModules as $modName ){
    $reg = __DIR__ . '/../modules/' . $modName . '/register.php';
    if( file_exists( $reg ) ) require $reg;
}

/* 2. Modules spécifiques workspace */
$workspaceModules = file_exists( $wsBase . '/modules.php' ) ? require $wsBase . '/modules.php' : [];
foreach( $workspaceModules as $modName ){
    $reg = $wsBase . '/modules/' . $modName . '/register.php';
    if( file_exists( $reg ) ) require $reg;
}

/* Affichage de la page Welcome si aucun contrôleur métier */
$hasControllers = !empty( glob( $wsControllers . '/*.php' ) );
$isDefault      = ( $workspace === 'default' || $workspace === '' || $workspace === null );
if( !$hasControllers && $isDefault ){
    echo $twig->render( 'welcome.html.twig' );
    exit;
}

/**
 * ===== Pipeline Générique ===== 
 */
$request = $_REQUEST;

$bootPipeline = $GLOBALS['corelia_boot_pipeline'] ?? [];

$finalHandler = function( $req ) use ( $wsControllers ){
    $router = new Router( $wsControllers );
    ob_start();

        $router->dispatch( $_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD'] );

    $out = ob_get_clean();

    if( $out ) return new \Corelia\Http\Response( $out );
    return null;
};

/* Compose le pipeline */
if( !empty( $bootPipeline ) ){
    $handler = array_reduce(
        array_reverse( $bootPipeline ),
        fn( $next, $fn ) => fn( $req ) => $fn( $req, $next ), $finalHandler
    );
    $resp = $handler( $request );
    if( $resp instanceof \Corelia\Http\Response ){
        $resp->send();
    }else{
        $resp = $finalHandler( $request );
        if( $resp instanceof \Corelia\Http\Response ) $resp->send();
    }
}