<?php

/* ===== ./core/Annotation/Put.php ===== */

namespace Corelia\Annotation;

use Attribute;

#[Attribute( Attribute::TARGET_METHOD )]
class Put
{

    public function __construct(
        public string $path,
        public ?string $name = null,
        public array $requirements = []
    ){}
    
}