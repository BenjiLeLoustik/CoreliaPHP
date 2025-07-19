<?php

/* ===== ./app/Controllers/AdminController.php ===== */

namespace App\Controllers;

use Corelia\Annotation\Get;
use Corelia\Controllers\AbstractController;

class AdminController extends AbstractController
{

    #[Get( path: '/admin', name: 'admin_dashboard' )]
    public function dashboard()
    {
        if( !$this->isAdmin() ){
            return $this->render( 'admin/forbidden.html.twig' );
        }

        return $this->render( 'admin/dashboard.html.twig', [
            'corelia_version' => $this->getConfig()['version'] ?? 'dev'
        ]);
    }

    #[Get( path: '/admin/modules', name: 'admin_modules' )]
    public function modules()
    {
        if( !$this->isAdmin() ){
            return $this->render( 'admin/forbidden.html.twig' );
        }

        $modules        = $this->scanModules();
        $activeModules  = $this->getActiveModules();

        return $this->render( 'admin/modules.html.twig', [
            'modules' => $modules,
            'active_modules' => $activeModules
        ]);
    }

    #[Get( path: '/admin/config', name: 'admin_config' )]
    public function config()
    {
        if( !$this->isAdmin() ){
            return $this->render( 'admin/forbidden.html.twig' );
        }

        $config = $this->getConfig();

        return $this->render( 'admin/config.html.twig', [
            'config' => $config
        ]);
    }

    #[Get( path: '/admin/workspaces', name: 'admin_workspaces' )]
    public function workspaces()
    {
        if( !$this->isAdmin() ){
            return $this->render( 'admin/forbidden.html.twig' );
        }

        $workspaces = $this->scanWorkspaces();

        return $this->render( 'admin/workspaces.html.twig', [
            'workspaces' => $workspaces
        ]);
    }


    /* Helpers internes */

    protected function scanModules(): array
    {
        $dir    = __DIR__ . '/../../../modules';
        $list   = [];
        
        if( is_dir( $dir ) ){
            foreach( scandir( $dir ) as $d ){
                if( $d !== '.' && $d !== '..' && is_dir( $dir . $d ) ){
                    $list[] = $d;
                }
            }
        }

        return $list;
    }

    protected function getActiveModules(): array
    {
        $file = __DIR__ . '/../../../config/modules.php';
        if( file_exists( $file ) ) return require $file;
        return [];
    }

    protected function scanWorkspaces(): array
    {
        $dir    = __DIR__ . '/../../../workspaces/';
        $list   = [];
        if( is_dir( $dir ) ){
            foreach( scandir( $dir ) as $ws ){
                if( $ws !== '.' && $ws !== '..' && is_dir( $dir . $ws ) ){
                    $list[] = $ws;
                }
            }
        }
        return $list;
    }

}