<?php

/* ===== ./core/Scan/ControllerScanner.php ===== */

namespace Corelia\Scan;

class ControllerScanner
{

    public static function scan( string $controllerDir ): array
    {
        $results    = [];
        $rii        = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator( $controllerDir )
        );

        foreach( $rii as $file ){
            if( $file->isFile() && $file->getExtension() === 'php' ){
                $results[] = $file->getPathname();
            }
        }

        return $results;
    }

}