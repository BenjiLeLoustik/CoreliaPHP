<?php

/* ===== ./core/Annotation/Get.php ===== */

namespace Corelia\Annotation;

use Attribute;

#[Attribute( Attribute::TARGET_METHOD )]
class Get
{

    public function __construct(
        public string $path,
        public ?string $name = null,
        public array $requirements = []
    ){}
    
}