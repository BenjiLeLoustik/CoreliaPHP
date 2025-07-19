<?php

/* ===== ./modules/Middlewares/MiddlewareRunner.php ===== */

namespace Modules\Middlewares;

use Module\middlewares\MiddlewareInterface;

class MiddlewareRunner
{

    private array $middlewares = [];

    public function add( MiddlewareInterface $middleware ): void
    {
        $this->middlewares[] = $middleware;
    }

    public function handle( $request, callable $controllerHandler )
    {
        $stack      = array_reverse( $this->middlewares );
        $handler    = $controllerHandler;
        foreach( $stack as $middleware ){
            $next    = $handler;
            $handler = function( $req ) use ( $middleware, $next ){
                return $middleware->process( $req, $next );
            };
        } 

        return $handler( $request );
    }

}