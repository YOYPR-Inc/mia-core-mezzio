<?php namespace Mia\Core\Diactoros;

/**
 * Description of MiaJsonResponse
 *
 * @OA\Schema()
 * @OA\Property(
 *  property="success",
 *  type="boolean",
 *  description=""
 * )
 * @OA\Property(
 *  property="response",
 *  type="object",
 *  description=""
 * )
 *
 * @author matiascamiletti
 */
class MiaJsonResponse extends \Laminas\Diactoros\Response\JsonResponse
{
    public function __construct($data) {
        parent::__construct(array(
            'success' => true,
            'response' => $data
        ));
    }
}