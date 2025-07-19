<?php

/* ===== ./modules/Middlewares/Middlewares.php ===== */

use Corelia\Module\ModuleInterface;

return new class implements ModuleInterface
{

    public function requiredFolders(): array
    {
        return ['Middlewares'];
    }

    public function boot( string $workspacePath ): void
    {}

};