<?php

namespace Mia\Core\Helper;

/**
 * Description of DateHelper
 *
 * @author matiascamiletti
 */
class MiaErrorHelper 
{
    public static function toLangEs(\Psr\Http\Message\ServerRequestInterface $request, $code, $messageEs, $message): \Mia\Core\Diactoros\MiaJsonErrorResponse
    {
        $lang = MiaRequestHelper::getParam($request, 'lang', 'en');
        if($lang == 'es'){
            return new \Mia\Core\Diactoros\MiaJsonErrorResponse($code, $messageEs);    
        }

        return new \Mia\Core\Diactoros\MiaJsonErrorResponse($code, $message);
    }
}
