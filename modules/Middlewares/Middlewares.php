<?php

/* ===== ./modules/Middlewares/Middlewares.php ===== */

namespace Modules\Middlewares;

class Middlewares
{

    private string $targetRoot;

    public function __construct( string $targetRoot )
    {
        $this->targetRoot = $targetRoot;
    }

    public function enable(): void
    {
        $path = $this->targetRoot . '/middlewares';
        if( !is_dir( $path ) ){
            mkdir( $path, 0775, true );
        }
    }

    public function loadMiddlewares(): array
    {
        $middlewares = [];
        $middlewarePath = $this->targetRoot . '/middlewares';

        foreach( glob( $middlewarePath . '/*.php' ) ?: [] as $file ){
            require_once $file;
            $base = pathinfo( $file, PATHINFO_FILENAME );

            $fqcn = "Middlewares\\{$base}";
            if( class_exists( $fqcn ) ){
                $middlewares[] = new $fqcn();
            }
        }

        return $middlewares;
    }

}