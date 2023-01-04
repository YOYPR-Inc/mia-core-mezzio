<?php

namespace Mia\Core\Handler;

use Mia\Core\Diactoros\MiaJsonErrorResponse;
use Mia\Core\Helper\GoogleTasksHelper;
use Mia\Core\Request\MiaRequestHandler;

class MiaTaskHandler extends MiaRequestHandler
{
    public function handle(\Psr\Http\Message\ServerRequestInterface $request): \Psr\Http\Message\ResponseInterface
    {
        // Get Secret Key
        $secretKey = $this->getParam($request, 'secret_key', '');
        // Init Service
        $service = GoogleTasksHelper::getInstance();
        // Verify if Valid Secret Key
        if(!$service->isValidSecretKey($secretKey)) {
            return new MiaJsonErrorResponse(-1, 'The secret key is incorrect.');
        }
        try {
            // Get task Name
            $taskName = $this->getParam($request, 'mia_task_name', '');
            // Create task
            $task = GoogleTasksHelper::getInstance()->container->get($taskName);
            // Execute task
            $task->process($this->getAllParam($request));
            // True response
            return new \Mia\Core\Diactoros\MiaJsonResponse(true);
        } catch (\Throwable $th) {
            return new MiaJsonErrorResponse(-1, $th->getMessage());
        }
    }
}