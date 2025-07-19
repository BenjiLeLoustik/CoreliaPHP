<?php

/* ===== ./core/Bootstrap/EnvLoader.php ===== */

namespace Corelia\Bootstrap;

class EnvLoader
{

    public static function load( string $envPath ): array
    {
        if( !file_exists( $envPath ) ) return [];
        $lines  = file( $envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES );
        $vars   = [];

        foreach( $lines as $line ){
            if( preg_match( '/^\s*#/', $line ) ) continue;
            if( strpos( $line, '=' ) !== false ){

                [ $k, $v ]  = explode( '=', $line, 2 );
                $vars[ trim( $k ) ] = trim( $v );
                
            }
        }

        return $vars;
    }

}