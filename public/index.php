<?php

/* ===== ./public/index.php ===== */

require_once __DIR__ . '/../vendor/autoload.php';

use Corelia\Bootstrap\Bootstrap;
use Corelia\Routing\Router;

Bootstrap::init();

$router = new Router( __DIR__ . '/../app/Controllers' );
$router->dispatch( $_SERVER['REQUEST_URI'], $_SERVER['REQUEST_MEHTHOD'] );
