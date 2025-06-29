<?php 

/* ===== /src/Controllers/DefaultController.php ===== */

namespace Src\Controllers;

use CoreliaPHP\Http\Request;
use CoreliaPHP\Http\Response;
use CoreliaPHP\Routing\Route;

class DefaultController
{
    #[Route(path: "/")]
    public function home(Request $request): Response
    {
        return new Response("Hello world from CoreliaPHP!");
    }
}