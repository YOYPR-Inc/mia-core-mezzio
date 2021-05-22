<?php

namespace Mia\Core\Handler;

use Psr\Http\Server\RequestHandlerInterface;

class MiaNotFoundHandler implements RequestHandlerInterface
{
    public function handle(\Psr\Http\Message\ServerRequestInterface $request): \Psr\Http\Message\ResponseInterface
    {
        return new \Mia\Core\Diactoros\MiaJsonErrorResponse(404, 'The service is not exist.');
    }
}