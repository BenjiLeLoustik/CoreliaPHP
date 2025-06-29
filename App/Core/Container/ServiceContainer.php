<?php

/* ===== /App/Core/Container/ServiceContainer.php ===== */

namespace App\Core\Container;

use ReflectionClass;
use ReflectionParameter;

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

        if (isset($this->services[$id])) {
            $this->instances[$id] = $this->services[$id]($this);
            return $this->instances[$id];
        }

        if (!class_exists($id)) {
            throw new \Exception("Service '{$id}' not found in container.");
        }

        // Injection automatique via réflexion
        $reflectionClass = new ReflectionClass($id);

        $constructor = $reflectionClass->getConstructor();
        if (is_null($constructor) || $constructor->getNumberOfParameters() === 0) {
            // Pas de constructeur ou sans paramètres => instanciation simple
            $instance = new $id();
            $this->instances[$id] = $instance;
            return $instance;
        }

        $parameters = $constructor->getParameters();
        $dependencies = [];

        foreach ($parameters as $parameter) {
            $dependency = $this->resolveParameter($parameter);
            $dependencies[] = $dependency;
        }

        $instance = $reflectionClass->newInstanceArgs($dependencies);
        $this->instances[$id] = $instance;
        return $instance;
    }

    protected function resolveParameter(ReflectionParameter $parameter)
    {
        $type = $parameter->getType();

        if ($type === null) {
            throw new \Exception("Cannot resolve the parameter '{$parameter->getName()}' without a type hint.");
        }

        if ($type->isBuiltin()) {
            // Type primitif (int, string, bool, etc.)
            if ($parameter->isDefaultValueAvailable()) {
                return $parameter->getDefaultValue();
            }
            throw new \Exception("Cannot resolve built-in parameter '{$parameter->getName()}' without default value.");
        }

        // C’est un type de classe/interface : on essaye de le récupérer dans le container
        $dependencyClassName = $type->getName();

        return $this->get($dependencyClassName);
    }
}