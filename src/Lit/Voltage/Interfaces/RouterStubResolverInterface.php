<?php

declare(strict_types=1);

namespace Lit\Voltage\Interfaces;

use Psr\Http\Server\RequestHandlerInterface;

interface RouterStubResolverInterface
{
    /**
     * Resolve the stub and return a RequestHandler
     *
     * @param mixed $stub
     * @return RequestHandlerInterface
     */
    public function resolve($stub): RequestHandlerInterface;
}
