<?php

/* ===== ./core/Module/ModuleInterface.php ===== */

namespace Corelia\Module;

interface ModuleInterface
{

    public function requiredFolders(): array;

    public function boot( string $workspacePath ): void;

}