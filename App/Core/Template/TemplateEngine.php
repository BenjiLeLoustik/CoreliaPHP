<?php

/* ===== App/Core/Template/TemplateEngine.php ===== */

namespace App\CoreTemplate;

class TemplateEngine
{
    protected string $cachePath;

    public function __construct(string $cachePath)
    {
        $this->cachePath = $cachePath;
    }

    /**
     * Rend un template avec un tableau de variables
     *
     * @param string $templateFile Chemin relatif au dossier Views
     * @param array $variables
     * @return string
     */
    public function render(string $templateFile, array $variables = []): string
    {
        $file = __DIR__ . '/../../../Views/' . $templateFile;
        if (!file_exists($file)) {
            throw new \Exception("Template {$templateFile} not found.");
        }

        $content = file_get_contents($file);

        // Simple substitution {{ var }}
        $content = preg_replace_callback('/\{\{\s*(\w+)\s*\}\}/', function ($matches) use ($variables) {
            $key = $matches[1];
            return $variables[$key] ?? '';
        }, $content);

        return $content;
    }
}