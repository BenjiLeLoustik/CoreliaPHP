<?php

/* ===== /App/Core/Controller/BaseController.php ===== */

namespace App\Core\Controller;

use App\Core\Template\TemplateEngine;

class BaseController
{

    protected TemplateEngine $template;

    public function __construct( TemplateEngine $template )
    {
        $this->template = $template;
    }

}