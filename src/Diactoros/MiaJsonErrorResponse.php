<?php namespace Mia\Core\Diactoros;

class MiaJsonErrorResponse extends \Laminas\Diactoros\Response\JsonResponse
{
    public function __construct($code, $message) {
        parent::__construct(array(
            'success' => false,
            'error' => array(
                'code' => $code,
                'message' => $message
            )
        ));
    }
}