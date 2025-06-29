<?php 

/* ===== /src/Controllers/DefaultController.php ===== */

namespace Src\Controllers;

use App\Core\Http\Request;
use App\Core\Http\Response;
use App\Core\Routing\Route;

class DefaultController
{
    #[Route(path: "/")]
    public function home(Request $request): Response
    {
        return new Response("Hello world from CoreliaPHP!");
    }
}