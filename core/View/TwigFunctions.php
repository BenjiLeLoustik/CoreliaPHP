<?php 

/* ===== ./core/View/TwigFunctions.php ===== */

namespace Corelia\View;

use Twig\TwigFunction;
use Twig\TwigFilter;
use Twig\TwigTest;

class TwigFunctions
{

    private static array $functions = [];
    private static array $globals   = [];

    public static function addNewFunction( string $name, callable $callback ): void
    {
        self::$functions[ $name ] = $callback;
    }

    public static function addNewGlobal( string $name, $value ): void
    {
        self::$globals[ $name ] = $value;
    }

    public static function registerAll( \Twig\Environment $twig ): void
    {
        foreach( self::$functions as $name => $cb ){
            $twig->addFunction( new TwigFunction( $name, $cb ) );
        }

        foreach( self::$globals as $name => $val ){
            $twig->addGlobal( $name, $val );
        }
    }

}