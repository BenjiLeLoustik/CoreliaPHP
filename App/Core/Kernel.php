<?php

/* ===== /App/Core/Kernel.php ===== */

namespace App\Core;

use App\Core\Http\Request;
use App\Core\Http\Response;
use App\Core\Routing\Router;
use App\Core\Container\ServiceContainer;

class Kernel
{
    protected ServiceContainer $container;
    protected Router $router;

    public function __construct()
    {
        $this->container = new ServiceContainer();
        $this->router = new Router($this->container);
    }

    public function boot(): void
    {
        // Charger les services core, modules (placeholder)
        // Ici on peut enregistrer les services de base
    }

    public function handle(Request $request): Response
    {
        // Trouver la route correspondante et exécuter le contrôleur
        $controllerResponse = $this->router->dispatch($request);

        if ($controllerResponse instanceof Response) {
            return $controllerResponse;
        }

        // Si ce n'est pas une Response, on considère que c'est le contenu à afficher
        return new Response((string)$controllerResponse);
    }
}