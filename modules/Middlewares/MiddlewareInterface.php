<?php

/* ===== ./modules/Middlewares/MiddlewareInterface.php ===== */

namespace Module\middlewares;

interface MiddlewareInterface
{

    public function process( $request, callable $next );

}