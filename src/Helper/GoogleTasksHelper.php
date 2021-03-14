<?php

namespace Mia\Core\Helper;

use Google\Cloud\Tasks\V2\AppEngineHttpRequest;
use Google\Cloud\Tasks\V2\CloudTasksClient;
use Google\Cloud\Tasks\V2\HttpMethod;
use Google\Cloud\Tasks\V2\Task;

/**
 * Description of CsvHelper
 *
 * @author matiascamiletti
 */
class GoolgeTasksHelper 
{
    /**
     * 
     */
    private static $instance = null;
    
    protected $projectId;
    protected $locationId;
    protected $queueId;
    protected $secretKey;
    /**
     * @var CloudTasksClient
     */
    protected $client;
    /**
     * @var string
     */
    protected $queueName = '';

    private function __construct($config)
    {
        $this->projectId = $config['project_id'];
        $this->locationId = $config['location_id'];
        $this->queueId = $config['queue_id'];
        $this->secretKey = $config['secret_key'];

        $this->client = new CloudTasksClient();
        $this->queueName = $this->client->queueName($this->projectId, $this->locationId, $this->queueId);
    }

    public function addTask($path, $params)
    {
        // Create an App Engine Http Request Object.
        $httpRequest = new AppEngineHttpRequest();
        // The path of the HTTP request to the App Engine service.
        $httpRequest->setRelativeUri($path);
        // POST is the default HTTP method, but any HTTP method can be used.
        $httpRequest->setHttpMethod(HttpMethod::POST);
        // Add Secret Key
        $params['secret_ket'] = $this->secretKey;
        // Setting a body value is only compatible with HTTP POST and PUT requests.
        $httpRequest->setBody(json_encode($params));

        // Create a Cloud Task object.
        $task = new Task();
        $task->setAppEngineHttpRequest($httpRequest);

        // Send request and print the task name.
        return $this->client->createTask($this->queueName, $task);
    }

    public static function init(\Psr\Container\ContainerInterface $container)
    {
        self::$instance = new GoolgeTasksHelper($container->get('config')['google_tasks']);
    }

    public static function getInstance(): GoolgeTasksHelper
    {
        return self::$instance;
    }
}