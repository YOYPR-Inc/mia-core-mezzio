<?php namespace Mia\Core\Diactoros;

class MiaJsonResponse extends \Laminas\Diactoros\Response\JsonResponse
{
    public function __construct($data) {
        parent::__construct(array(
            'success' => true,
            'response' => $data
        ));
    }
}