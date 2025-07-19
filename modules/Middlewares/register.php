<?php

/* ===== ./modules/Middlewares/register.php ===== */

/* Récupéra le scope cible */
$scopeRoot = defined('CORELIA_SCOPE_ROOT') ? CORELIA_SCOPE_ROOT : __DIR__ . '/../../app';

/* Activer le module : Créera le dossier middlewares s'il n'existe pas encore */
$module = new \Modules\Middlewares\Middlewares( $scopeRoot );
$module->enable();

/* Charger dynamiquement les middlewares */
$_GLOBALS['corelia_middlewares'][ $scopeRoot ] = function() use ( $module ){
    $runner = new \Modules\Middlewares\MiddlewareRunner();
    foreach( $module->loadMiddlewares() as $mw ){
        $runner->add( $mw );
    }

    return $runner;
};