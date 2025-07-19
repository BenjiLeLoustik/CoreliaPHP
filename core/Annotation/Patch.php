<?php

/* ===== ./core/Annotation/Patch.php ===== */

namespace Corelia\Annotation;

use Attribute;

#[Attribute( Attribute::TARGET_METHOD )]
class Patch
{

    public function __construct(
        public string $path,
        public ?string $name = null,
        public array $requirements = []
    ){}
    
}