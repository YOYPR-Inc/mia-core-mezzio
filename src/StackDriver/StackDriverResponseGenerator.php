<?php namespace Mia\Core\StackDriver;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Throwable;

/**
 * Description of StackDriverResponseGenerator
 *
 * @author matiascamiletti
 */
class StackDriverResponseGenerator 
{
    public function __invoke(
        Throwable $e,
        ServerRequestInterface $request,
        ResponseInterface $response
    ) : ResponseInterface {
        // Walk through all handlers
        /*foreach ($this->whoops->getHandlers() as $handler) {
            // Add fancy data for the PrettyPageHandler
            if ($handler instanceof PrettyPageHandler) {
                $this->prepareWhoopsHandler($request, $handler);
            }

            // Set Json content type header
            if ($handler instanceof JsonResponseHandler) {
                $contentType = 'application/json';

                // Whoops < 2.1.5 does not provide contentType method
                if (method_exists($handler, 'contentType')) {
                    $contentType = $handler->contentType();
                }

                $response = $response->withHeader('Content-Type', $contentType);
            }
        }

        $response = $response->withStatus(Utils::getStatusCode($e, $response));

        $sendOutputFlag = $this->whoops->writeToOutput();
        $this->whoops->writeToOutput(false);
        $response
            ->getBody()
            ->write($this->whoops->handleException($e));
        $this->whoops->writeToOutput($sendOutputFlag);*/
        // Registrar exception en StackDriver
        \Google\Cloud\ErrorReporting\Bootstrap::exceptionHandler($e);

        return $response;
    }
}