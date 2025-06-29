<?php

/* ===== /App/Console/Console.php ===== */

namespace App\Console;

use App\Console\Commands\MakeControllerCommand;

class Console 
{

    protected array $commands = [];

    public function __construct()
    {
        $this->register( 'make:controller', new MakeControllerCommand );
    }

    public function register( string $name, callable $callback ): void
    {
        $this->commands[$name] = $callback;
    }

    public function run( array $argv ): void
    {
        if( count( $argv ) < 2 ){
            $this->printHelp();
            exit(0);
        }

        $commandName = $argv[1];

        if( !isset( $this->commands[$commandName] ) ){
            echo "Cette commande est inconnue : $commandName\n";
            $this->printHelp();
            exit(1);
        }

        $command = $this->commands[$commandName];
        $command( array_slice( $argv, 2 ) );
    }

    protected function printHelp(): void
    {
        echo "Utilisation : php corelia <commande> [arguments]\n";
        echo "Commandes disponibles :\n";
        foreach( array_keys( $this->commands ) as $cmd ){
            echo "   - $cmd\n";
        }
    }

}