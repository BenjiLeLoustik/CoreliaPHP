<?php

/* ===== /App/Core/Container/ServiceContainer.php ===== */

namespace App\Core\Container;

class ServiceContainer
{
    protected array $services = [];
    protected array $instances = [];

    public function set(string $id, callable $callable): void
    {
        $this->services[$id] = $callable;
    }

    public function get(string $id): object
    {
        if (isset($this->instances[$id])) {
            return $this->instances[$id];
        }

        if (!isset($this->services[$id])) {
            throw new \Exception("Service '{$id}' not found in container.");
        }

        $this->instances[$id] = $this->services[$id]($this);

        return $this->instances[$id];
    }
}