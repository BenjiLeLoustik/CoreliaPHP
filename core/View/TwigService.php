<?php 

/* ===== ./core/View/TwigService.php ===== */

namespace Corelia\View;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Corelia\Config\Container;
use Corelia\View\TwigFunctions;

class TwigService
{

    private Environment $twig;

    public function __construct( string $viewsPath )
    {
        $loader = new FilesystemLoader( $viewsPath );
        $this->twig = new Environment( $loader, [
            'cache' => false,
            'debug' => $this->getDebugFlag(),
        ]);

        $this->injectGlobals();
        TwigFunctions::registerAll( $this->twig );
    }

    private function getDebugFlag(): bool
    {
        $config = Container::getInstance()->get('config');
        return !empty( $config['debug'] );
    }

    private function injectGlobals(): void
    {
        $container = Container::getInstance();
        $this->twig->addGlobal( 'ENV', $container->get('env') );
        $this->twig->addGlobal( 'CORELIA', $container->get('config') );
    }

    public function getTwig(): Environment
    {
        return $this->twig;
    }

}