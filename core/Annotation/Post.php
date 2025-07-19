<?php

/* ===== ./core/Annotation/Post.php ===== */

namespace Corelia\Annotation;

use Attribute;

#[Attribute( Attribute::TARGET_METHOD )]
class Post
{

    public function __construct(
        public string $path,
        public ?string $name = null,
        public array $requirements = []
    ){}
    
}