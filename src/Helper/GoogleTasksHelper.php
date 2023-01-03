<?php

namespace Mia\Core\Helper;

use Google\Cloud\Tasks\V2\AppEngineHttpRequest;
use Google\Cloud\Tasks\V2\CloudTasksClient;
use Google\Cloud\Tasks\V2\HttpMethod;
use Google\Cloud\Tasks\V2\Task;
use Google\Cloud\Tasks\V2\HttpRequest;
use Google\Protobuf\Timestamp;

/**
 * Description of CsvHelper
 *
 * @author matiascamiletti
 */
class GoogleTasksHelper 
{
    /**
     * 
     */
    private static $instance = null;
    
    protected $projectId;
    protected $locationId;
    protected $secretKey;
    /**
     * @var CloudTasksClient
     */
    protected $client;
    /**
     * @var \Psr\Container\ContainerInterface
     */
    public $container;

    private function __construct($config)
    {
        $this->projectId = $config['project_id'];
        $this->locationId = $config['location_id'];
        //$this->queueId = $config['queue_id'];
        $this->secretKey = $config['secret_key'];

        try {
            $this->client = new CloudTasksClient();
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function addTaskHttp($queueId, $url, $params, \DateTime $scheduleTime = null)
    {
        // Create an App Engine Http Request Object.
        $httpRequest = new HttpRequest();
        $httpRequest->setUrl($url);
        // POST is the default HTTP method, but any HTTP method can be used.
        $httpRequest->setHttpMethod(HttpMethod::POST);
        // Setting a body value is only compatible with HTTP POST and PUT requests.
        $httpRequest->setHeaders(['Content-Type' => 'application/json']);
        $httpRequest->setBody(json_encode($params));
        // Create a Cloud Task object.
        $task = new Task();
        $task->setHttpRequest($httpRequest);

        if($scheduleTime != null){
            $timestamp = new Timestamp();
            $timestamp->fromDateTime($scheduleTime);
            $task->setScheduleTime($timestamp);
        }

        // Create Queue
        $queueName = $this->client->queueName($this->projectId, $this->locationId, $queueId);

        // Send request and print the task name.
        return $this->client->createTask($queueName, $task);
    }

    public function addTask($queueId, $path, $params, $service = null)
    {
        // Create an App Engine Http Request Object.
        $httpRequest = new AppEngineHttpRequest();
        // The path of the HTTP request to the App Engine service.
        $httpRequest->setRelativeUri($path);

        if($service !== null){
            $routing = new \Google\Cloud\Tasks\V2\AppEngineRouting();
            $routing->setService($service);

            $httpRequest->setAppEngineRouting($routing);
        }

        // POST is the default HTTP method, but any HTTP method can be used.
        $httpRequest->setHttpMethod(HttpMethod::POST);
        // Add Secret Key
        $params['secret_key'] = $this->secretKey;
        // Setting a body value is only compatible with HTTP POST and PUT requests.
        $httpRequest->setHeaders(['Content-Type' => 'application/json']);
        $httpRequest->setBody(json_encode($params));

        // Create a Cloud Task object.
        $task = new Task();
        $task->setAppEngineHttpRequest($httpRequest);

        // Create Queue
        $queueName = $this->client->queueName($this->projectId, $this->locationId, $queueId);

        // Send request and print the task name.
        return $this->client->createTask($queueName, $task);
    }
    /**
     * Verify if secret key is valid
     */
    public function isValidSecretKey($key) : bool
    {
        if($this->secretKey == $key){
            return true;
        }

        return false;
    }

    public static function executeTask($taskClassName, $params)
    {
        $task = self::getInstance()->container->get($taskClassName);
        $task->run($taskClassName, $params);
    }

    public static function init(\Psr\Container\ContainerInterface $container)
    {
        self::$instance = new GoogleTasksHelper($container->get('config')['google_tasks']);
        self::$instance->container = $container;
    }

    public static function getInstance(): GoogleTasksHelper
    {
        return self::$instance;
    }
    /**
     * Verify if Google Task is Active
     */
    public static function isActive(): bool
    {
        if(self::$instance === null){
            return false;
        }

        return true;
    }
}