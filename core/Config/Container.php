<?php

/* ===== ./core/Config/Container.php ===== */

namespace Corelia\Config;

class Container
{

    private static ?self $instance = null;
    private array $data = [];

    private function __construct()
    {}

    public static function getInstance(): self
    {
        if( !self::$instance ) self::$instance = new self();
        return self::$instance;
    }

    public function set( string $key, $value ): void
    {
        $this->data[ $key ] = $value;
    }

    public function get( string $key )
    {
        return $this->data[ $key ] ?? null;
    }

    public function has( string $key ): bool
    {
        return array_key_exists( $key, $this->data );
    }

}