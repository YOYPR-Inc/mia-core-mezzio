<?php

namespace Mia\Core\Middleware;

use Psr\Container\ContainerInterface;

/**
 * Description of StackDriverErrorMiddleware
 *
 * @author matiascamiletti
 */
class StackDriverErrorMiddleware
{
    public function __invoke(ContainerInterface $container): \Mia\Core\StackDriver\StackDriverResponseGenerator
    {
        // Iniciar reporting
        if (isset($_SERVER['GAE_SERVICE'])) {
            \Google\Cloud\ErrorReporting\Bootstrap::init();
        }
        // Devolver cualquier objeto
        return new \Mia\Core\StackDriver\StackDriverResponseGenerator();
    }
}
