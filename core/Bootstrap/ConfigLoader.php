<?php

/* ===== ./core/Bootstrap/ConfigLoader.php ===== */

namespace Corelia\Bootstrap;

class ConfigLoader
{

    public static function load( string $jsonPath ): array
    {
        if( !file_exists( $jsonPath ) ) return [];
        $json = file_get_contents( $jsonPath );
        return json_decode( $json, true ) ?: [];
    }

}