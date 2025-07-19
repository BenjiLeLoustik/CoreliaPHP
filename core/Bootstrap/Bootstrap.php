<?php

/* ===== ./core/Bootstrap/Bootstrap.php ===== */

namespace Corelia\Bootstrap;

use Corelia\Config\Container;

class Bootstrap
{

    public static function init(): void
    {
        $envVars    = EnvLoader::load( __DIR__ . '/../../../.env' );
        $config     = ConfigLoader::load( __DIR__ . '/../../../config/framework.json' );
        $container  = Container::getInstance();

        $container->set( 'env', $envVars );
        $container->set( 'config', $config );
    }

}