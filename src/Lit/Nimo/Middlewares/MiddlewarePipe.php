<?php

declare(strict_types=1);

namespace Lit\Nimo\Middlewares;

use Lit\Nimo\Handlers\PipeNextHandler;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;

class MiddlewarePipe extends AbstractMiddleware
{
    /**
     * @var MiddlewareInterface[]
     */
    protected $stack = [];

    /**
     * append $middleware
     * return $this
     * note this method would modify $this
     *
     * @param MiddlewareInterface $middleware
     * @return $this
     */
    public function append(MiddlewareInterface $middleware): MiddlewarePipe
    {
        $this->stack[] = $middleware;
        return $this;
    }

    /**
     * prepend $middleware
     * return $this
     * note this method would modify $this
     *
     * @param MiddlewareInterface $middleware
     * @return $this
     */
    public function prepend(MiddlewareInterface $middleware): MiddlewarePipe
    {
        array_unshift($this->stack, $middleware);
        return $this;
    }

    protected function main(): ResponseInterface
    {
        return $this->iterate($this->request, 0);
    }

    protected function next(int $index): PipeNextHandler
    {
        return new PipeNextHandler($this, $index);
    }

    /**
     * @param ServerRequestInterface $request
     * @param int $index
     * @return ResponseInterface
     * @internal
     */
    public function iterate(ServerRequestInterface $request, int $index): ResponseInterface
    {
        if (!isset($this->stack[$index])) {
            return $this->delegate($request);
        }

        return $this->stack[$index]->process($request, $this->next($index + 1));
    }
}
