<?php

/* ===== ./modules/Middlewares/register.php ===== */

/* Récupéra le scope cible */

use Modules\Middlewares\MiddlewareRunner;

$scopeRoot = defined('CORELIA_SCOPE_ROOT') ? constant("CORELIA_SCOPE_ROOT") : __DIR__ . '/../../app';

/* Activer le module : Créera le dossier middlewares s'il n'existe pas encore */
$module = new \Modules\Middlewares\Middlewares( $scopeRoot );
$module->enable();

/* Charger dynamiquement les middlewares */
$GLOBALS['corelia_boot_pipeline'][] = function( $request, $next ) use( $module ){
    $runner = new MiddlewareRunner();
    foreach( $module->loadMiddlewares() as $mw ){
        $runner->add( $mw );
    }

    return $runner->handle( $request, $next );
};