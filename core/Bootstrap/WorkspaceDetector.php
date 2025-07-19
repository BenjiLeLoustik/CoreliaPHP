<?php

/* ===== ./core/Bootstrap/WorkspacesDetector.php ===== */

namespace Corelia\Bootstrap;

class WorkspaceDetector
{

    public static function detect(): string
    {
        $uri    = $_SERVER['REQUEST_URI'] ?? '/';
        $parts  = explode( '/', trim( $uri, '/' ) );
        
        return $parts[0] !== '' ? $parts[0] : 'default';
    }

}