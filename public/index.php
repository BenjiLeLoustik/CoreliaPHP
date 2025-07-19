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
$wsRoot         = is_dir( __DIR__ . "/../workspaces/$workspace" ) ? __DIR__ . "/../workspaces/$workspace" : __DIR__ . '/../app';
$wsControllers  = $wsRoot . "/Controllers";
$wsViews        = $wsRoot . "/Views";

/* Initialisation de TwigService */
$twigService    = new TwigService( $wsViews );
$twig           = $twigService->getTwig();
Container::getInstance()->set( 'twig', $twig ); 

/* Activation dynamique des modules (ex. Middlewares) */
if( is_dir( __DIR__ . '/../modules/Middlewares' ) ){
    define( 'CORELIA_SCOPE_ROOT', $wsRoot );
    require __DIR__ . '/../modules/Middlewares/register.php';
}

/* Vérification de l'éxistance du contrôleur sinon affiche la page Welcome */
$hasControllers = !empty( glob( $wsControllers . '/*.php' ) );
$isDefault = ( $workspace === 'default' || $workspace === '' || $workspace === null );

/* Rendu Welcome si aucun contrôleur métier ou workspace actif */
if( !$hasControllers && $isDefault ){
    echo $twig->render( 'welcome.html.twig' );
    exit;
}


/* Execution pipeline : Middlewares (Si module activé) + Router */
$corelia_middleware_loader = $_GLOBALS['corelia_middlewares'][ $wsRoot ] ?? null;

if( $corelia_middleware_loader ){
    $runner = $corelia_middleware_loader();

    $rest = $runner->handle( $_REQUEST, function( $request ) use ( $wsControllers ) {
        $router = new Router( $wsControllers );
        ob_start();
        $router->dispatch( $_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD'] );
        $output = ob_get_clean();
        
        if( $output ){
            return new \Corelia\Http\Response( $output );
        }
    });

    if( $resp instanceof \Corelia\Http\Response ){
        $resp->send();
    }
}else{
    $router = new Router( $wsControllers );
    $router->dispatch( $_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD'] );
}
