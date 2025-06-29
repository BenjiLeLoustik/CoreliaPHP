<?php

namespace Src\Controllers;

use App\Core\Http\Request;
use App\Core\Controller\BaseController;
use App\Core\Routing\Route;

class TestController extends BaseController
{

    #[Route(path: "/test")]
    public function index( Request $request )
    {
        return $this->template->render("Test/index.ctpl", []);    
    } 

}