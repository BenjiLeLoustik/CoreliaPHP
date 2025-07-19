<?php

/* ===== ./core/Routing/RouteDefinition.php ===== */

namespace Corelia\Routing;

class RouteDefinition
{

    public function __construct(
        public string $httpMethod,
        public string $path,
        public string $controllerClass,
        public string $methodName,
        public ?string $name = null,
        public array $requirements = []
    ){}

}