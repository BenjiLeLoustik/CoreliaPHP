<?php 

/* ===== App/Core/Routing/Router.php ===== */

namespace App\Core\Routing;

use App\Core\Container\ServiceContainer;
use App\Core\Http\Request;
use App\Core\Http\Response;
use ReflectionClass;
use ReflectionMethod;

class Router
{
    protected ServiceContainer $container;
    protected array $routes = [];

    public function __construct(ServiceContainer $container)
    {
        $this->container = $container;
        $this->loadRoutes();
    }

    protected function loadRoutes(): void
    {
        $controllerPath = __DIR__ . '/../../../src/Controllers';
        if (!is_dir($controllerPath)) {
            return;
        }

        $files = scandir($controllerPath);
        foreach ($files as $file) {
            if (str_ends_with($file, '.php')) {
                $className = 'App\\Controllers\\' . pathinfo($file, PATHINFO_FILENAME);
                if (class_exists($className)) {
                    $this->registerRoutesFromController($className);
                } else {
                    require_once $controllerPath . '/' . $file;
                    if (class_exists($className)) {
                        $this->registerRoutesFromController($className);
                    }
                }
            }
        }
    }

    protected function registerRoutesFromController(string $className): void
    {
        $reflection = new ReflectionClass($className);
        $methods = $reflection->getMethods(ReflectionMethod::IS_PUBLIC);

        foreach ($methods as $method) {
            $attributes = $method->getAttributes(Route::class);
            foreach ($attributes as $attribute) {
                /** @var Route $route */
                $route = $attribute->newInstance();
                $path = $route->path;
                $methods = $route->methods ?: ['GET'];

                $this->routes[] = [
                    'path' => $path,
                    'methods' => $methods,
                    'controller' => $className,
                    'method' => $method->getName(),
                ];
            }
        }
    }

    public function dispatch(Request $request): Response|string
    {
        $requestPath = $request->getPath();
        $requestMethod = $request->getMethod();

        foreach ($this->routes as $route) {
            if ($route['path'] === $requestPath && in_array($requestMethod, $route['methods'])) {
                $controller = $this->container->get($route['controller']);
                $method = $route['method'];
                return $controller->$method($request);
            }
        }

        // Aucun route trouvée : fallback vue bienvenue
        return $this->renderWelcome();
    }

    protected function renderWelcome(): string
    {
        $file = __DIR__ . '/../../../Views/Welcome/no_controller.ctpl';
        if (!file_exists($file)) {
            return "Bienvenue dans CoreliaPHP ! Aucun contrôleur détecté.";
        }

        $content = file_get_contents($file);
        return $content;
    }
}