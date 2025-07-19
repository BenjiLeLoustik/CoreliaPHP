<?php

/* ===== ./core/Module/ModuleManager.php ===== */

namespace Corelia\Module;

class ModuleManager
{

    private string $workspacePath;
    private array $modules = [];

    public function __construct( string $workspacePath )
    {
        $this->workspacePath = $workspacePath;
    }

    public function scanModules( string $modulesDir ): array
    {
        $dirs = glob( $modulesDir . '/*', GLOB_ONLYDIR ) ?: [];
        foreach( $dirs as $dir ){

            $name       = basename( $dir );
            $mainFile   = $dir . '/' . $name . '.php';

            if( file_exists( $mainFile ) ){
                $this->modules[ $name ] = require $mainFile;
            }

        }

        return $this->modules;
    }

    public function activate( string $moduleName ): bool
    {
        if( isset( $this->modules[ $moduleName ] ) ){
            $module = $this->modules[ $moduleName ];

            if( $module instanceof ModuleInterface ){
                foreach( $module->requiredFolders() as $folder ){
                    $fullpath = $this->workspacePath . '/' . $folder;

                    if( !is_dir( $fullpath ) ) mkdir( $fullpath, 0775, true );
                }

                $module->boot( $this->workspacePath );
                return true;
            }

        }

        return false;
    }

    public function desactivate( string $moduleName ): bool
    {
        return true;
    }

}