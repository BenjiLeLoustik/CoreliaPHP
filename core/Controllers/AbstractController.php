<?php

/* ===== ./core/Controller/AbstractController.php ===== */

namespace Corelia\Controllers;

use Corelia\Config\Container;
use Corelia\Http\Response;
use Corelia\Http\RedirectResponse;
use Corelia\Http\JsonResponse;

abstract class AbstractController
{

    /** @var Container */
    protected Container $container;

    public function __construct()
    {  
        $this->container = Container::getInstance(); 
    }

    protected function render( string $template, array $variables = [] ): Response
    {
        $twig = $this->container->get('twig');
        return new Response( $twig->render( $template, $variables ) );
    }

    protected function getConfig(): array
    {
        return $this->container->get('config') ?? [];
    }

    protected function getEnv(): array
    {
        return $this->container->get('env');
    }

    protected function getService( string $key )
    {
        return $this->container->get( $key );
    }

    protected function redirect( string $url, int $status = 302 ): Response
    {
        return new RedirectResponse( $url, $status );
    }

    protected function json( $data, int $status = 200 ): Response
    {
        return new JsonResponse( $data, $status );
    }

    protected function isAdmin(): bool
    {
        return ( getenv( 'APP_ENV' ) === 'dev' || ( $_SESSION['admin'] ?? false ) );
    }

}