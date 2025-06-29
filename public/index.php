<?php 

/* ===== /public/index.php ===== */

require_once __DIR__ . '/../vendor/autoload.php';

use App\Core\Http\Request;
use App\Core\Kernel;

$kernel = new Kernel();
$kernel->boot();

$request = new Request();
$response = $kernel->handle($request);

$response->send();