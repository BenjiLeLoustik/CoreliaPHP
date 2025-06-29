<?php 

/* ===== /App/Core/Http/Request.php ===== */

namespace App\Core\Http;

class Request
{
    protected array $get;
    protected array $post;
    protected array $server;

    public function __construct()
    {
        $this->get = $_GET;
        $this->post = $_POST;
        $this->server = $_SERVER;
    }

    public function getMethod(): string
    {
        return strtoupper($this->server['REQUEST_METHOD'] ?? 'GET');
    }

    public function getPath(): string
    {
        $uri = $this->server['REQUEST_URI'] ?? '/';
        $pos = strpos($uri, '?');
        if ($pos !== false) {
            $uri = substr($uri, 0, $pos);
        }
        return $uri;
    }

    public function getQueryParams(): array
    {
        return $this->get;
    }

    public function getPostParams(): array
    {
        return $this->post;
    }
}