<?php namespace Mia\Core\Middleware;

/**
 * Description of MiaBaseMiddleware
 *
 * @author matiascamiletti
 */
abstract class MiaBaseMiddleware implements \Psr\Http\Server\MiddlewareInterface
{
    /**
     * Obtener parametro sin importar de donde provenga.
     */
    protected function getParam(\Psr\Http\Message\ServerRequestInterface $request, $key, $default = null)
    {
        // Obtener parametros
        $params = $request->getParsedBody();
        // verificar si fue enviado
        if(array_key_exists($key, $params)){
            return $params[$key];
        }
        // Obtener Querys
        $querys = $request->getQueryParams();
        if(array_key_exists($key, $querys)){
            return $querys[$key];
        }
        return $default;
    }
}