<?php

declare(strict_types=1);

namespace Lit\Voltage\Traits;

use Psr\Http\Message\ResponseInterface;

trait ViewTrait
{
    /**
     * @var ResponseInterface
     */
    protected $response;

    /**
     *
     * @param ResponseInterface $response
     */
    public function setResponse(ResponseInterface $response): void
    {
        $this->response = $response;
    }

    /**
     * ensure body is empty and writable and return that
     *
     * @return \Psr\Http\Message\StreamInterface
     * @throws \RuntimeException
     */
    protected function getEmptyBody()
    {
        $body = $this->response->getBody();
        if (!$body->isWritable()) {
            throw new \RuntimeException('response body is not writeble');
        }
        if ($body->getSize() !== 0) {
            throw new \RuntimeException('response body is not empty');
        }

        return $body;
    }
}
