<?php

/* ===== ./core/Routing/Router.php ===== */

namespace Corelia\Routing;

use Corelia\Scan\ControllerScanner;
use ReflectionClass;

class Router
{

    /** @var RouteDefinition[] */
    private array $routes = [];

    public function __construct( string $controllersDir )
    {
        $this->registerRoutes( $controllersDir );
    }

    private function registerRoutes( string $controllersDir ): void
    {
        foreach( ControllerScanner::scan( $controllersDir ) as $controllerFile ){
            require_once $controllerFile;
            $classes = $this->getClassesInFile( $controllerFile );
            foreach( $classes as $class ){
                $this->extractRoutes( $class );
            }
        }
    }

    private function getClassesInFile( string $file ): array
    {
        $declared = get_declared_classes();
        require_once $file;
        $new = array_diff( get_declared_classes(), $declared );
        return $new;
    }

    private function extractRoutes( string $controllerClass ): void
    {
        $refl = new ReflectionClass( $controllerClass );
        foreach( $refl->getMethods() as $method ){

            foreach( ['Get', 'Post', 'Put', 'Delete', 'Patch'] as $verb ){

                $fqcn = "Corelia\\Annotation\\$verb";
                foreach( $method->getAttributes( $fqcn ) as $attr ){
                    $args = $attr->getArguments();
                    $this->routes[] = new RouteDefinition(
                        strtoupper( $verb ),
                        $args['path'] ?? $args[0],
                        $controllerClass,
                        $args['name'] ?? null,
                        $args['requirements'] ?? []
                    );
                }

            }

        }
    }

    public function dispatch( string $path, string $method ): void
    {
        foreach( $this->routes as $route ){
            
            if( $route->httpMethod === strtoupper( $method ) && $route->path === $path ){
                $controller = new $route->controllerClass();
                $response   = $controller->{$route->methodName}();

                if( $response instanceof \Corelia\Http\Response ){
                    $response->send();
                    return;
                }
            }

        }

        /* Erreur 404 */
        ( new \Corelia\Http\Response( 'Not Found', 404 ) )->send();
    }

}