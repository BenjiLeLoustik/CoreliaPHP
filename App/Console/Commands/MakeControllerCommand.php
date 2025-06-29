<?php

/* ===== App/Console/Command/MakeControllerCommand.php ===== */

namespace App\Console\Commands;

class MakeControllerCommand
{

    public function __invoke( array $args ): void
    {
        if( empty( $args[0] ) ){
            echo "Utilisation : php corelia make:controller <ControllerName>\n";
            return;
        }

        $name = $args[0];

        $controllerName = $name;
        if( !str_ends_with( $name, 'Controller' ) ){
            $controllerName .= 'Controller';
        }

        $controllerDir = __DIR__ . '/../../../src/Controllers';
        if( !is_dir( $controllerDir ) ){
            mkdir( $controllerDir, 0755, true );
        }

        $filePath = $controllerDir . '/' . $controllerName . '.php';

        if( file_exists( $filePath ) ){
            echo "Erreur : Le controlleur {$controllerName} éxiste déjà.\n";
            return;
        }

        $routePath = strtolower( $name );

        $template = <<<PHP
                    <?php

                    namespace Src\Controllers;

                    use App\Core\Http\Request;
                    use App\Core\Controller\BaseController;
                    use App\Core\Routing\Route;

                    class $controllerName extends BaseController
                    {

                        #[Route(path: "/{$routePath}")]
                        public function index( Request \$request )
                        {
                            return \$this->template->render("{$name}/index.ctpl", []);    
                        } 

                    }
                    PHP;
                           
        file_put_contents( $filePath, $template );
        echo "Succès : Le controlleur {$controllerName} a bien été crée dans ./src/Controllers/.\n";

        $viewDir = __DIR__ . "/../../../views/" . strtolower( $name );
        if( !is_dir( $viewDir ) ){
            mkdir( $viewDir, 0755, true );
        }

        $viewFile = $viewDir . "/index.ctpl";
        if( file_exists( $viewFile ) ){
            echo "Erreur : Le template {$viewFile} éxiste déjà pour votre controlleur.\n";
        }else{
            $defaultViewContent =   <<<TPL
                                    <section class="welcome">
                                        <h1>✅ Félicitations, votre page a bien été créée !</h1>
                                        <p>
                                            <strong>Contrôleur :</strong> {$controllerName}<br>
                                            <strong>Vue :</strong> /Views/{$name}/index.ctpl
                                        </p>
                                    </section>
                                    <style>
                                        body {
                                            font-family: 'Segoe UI', sans-serif;
                                            background: #f4f9ff;
                                            color: #1e3a5f;
                                            margin: 0;
                                            padding: 0;
                                        }

                                        .welcome {
                                            max-width: 640px;
                                            margin: 48px auto;
                                            background: white;
                                            border-radius: 16px;
                                            padding: 40px 48px;
                                            box-shadow: 0 2px 12px rgba(0,0,0,0.05);
                                            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                                            color: #003a8c;
                                        }

                                        .welcome h1 {
                                            font-weight: 900;
                                            font-size: 2.3rem;
                                            margin-bottom: 36px;
                                            color: #002e75;
                                            letter-spacing: -0.04em;
                                        }

                                        .welcome p {
                                            font-size: 1.3rem;
                                            line-height: 1.7;
                                        }

                                        .welcome strong {
                                            color: #0056b3;
                                        }
                                    </style>
                                    TPL;

            file_put_contents( $viewFile, $defaultViewContent );
            echo "Succès : La vue du controlleur {$controllerName} a bien été crée dans ./Views/{$name}/index.ctpl.\n";
        }
    }

}