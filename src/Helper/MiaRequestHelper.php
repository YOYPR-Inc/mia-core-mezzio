<?php

namespace Mia\Core\Helper;

/**
 * Description of DateHelper
 *
 * @author matiascamiletti
 */
class MiaRequestHelper 
{
    /**
     * Obtener parametro sin importar de donde provenga.
     */
    public static function getParam(\Psr\Http\Message\ServerRequestInterface $request, $key, $default = null)
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
        return $request->getAttribute($key, $default);
    }
}
