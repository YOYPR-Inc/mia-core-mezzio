<?php namespace Mia\Core\Task;

use Mia\Core\Helper\GoogleTasksHelper;

abstract class MiaTask
{
    /**
     * Queue ID String
     */
    protected $queueId;
    /**
     * Path Relative URL in App Engine
     */
    protected $path = '/mia-task/google-task';

    abstract public function process($params);

    public function run($params)
    {
        if(!GoogleTasksHelper::isActive()){
            $this->process($params);
            return;
        }

        $params['mia_task_name'] = self::class;

        try {
            GoogleTasksHelper::getInstance()->addTask($this->queueId, $this->path, $params);
        } catch (\Throwable $th) {
            $this->process($params);
        }
    }
}