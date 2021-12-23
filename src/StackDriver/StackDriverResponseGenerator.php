<?php namespace Mia\Core\StackDriver;

use Mia\Core\Diactoros\MiaJsonErrorResponse;
use Mia\Core\Exception\MiaException;
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
        // Registrar exception en StackDriver
        if(!($e instanceof MiaException)){
            \Google\Cloud\ErrorReporting\Bootstrap::exceptionHandler($e);
        }

        $response = [
            'type'    => get_class($e),
            'message' => $e->getMessage(),
            'code'    => $e->getCode(),
            'file'    => $e->getFile(),
            'line'    => $e->getLine(),
        ];

        return new \Laminas\Diactoros\Response\JsonResponse(array(
            'success' => false,
            'error' => $response
        ));
    }
}