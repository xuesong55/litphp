<?php

declare(strict_types=1);

namespace Lit\Nimo;

use Lit\Nimo\Traits\MiddlewareTrait;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

abstract class AbstractMiddleware implements MiddlewareInterface
{
    use MiddlewareTrait;
    /**
     * @var ServerRequestInterface
     */
    protected $request;

    /**
     * @var RequestHandlerInterface
     */
    protected $handler;


    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $this->request = $request;
        $this->handler = $handler;

        return $this->main();
    }

    /**
     * @return ResponseInterface
     */
    abstract protected function main(): ResponseInterface;

    protected function delegate(ServerRequestInterface $request = null): ResponseInterface
    {
        return $this->handler->handle($request ?: $this->request);
    }
}
