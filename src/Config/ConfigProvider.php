<?php

declare(strict_types=1);

namespace Mia\Core\Config;

/**
 * The configuration provider for the App module
 *
 */
class ConfigProvider
{
    /**
     * Returns the configuration array
     *
     * To add a bit of a structure, each section is defined in a separate
     * method which returns an array with its configuration.
     *
     */
    public function __invoke() : array
    {
        return [
            'dependencies' => $this->getDependencies(),
        ];
    }

    /**
     * Returns the container dependencies
     */
    public function getDependencies() : array
    {
        return [
            'invokables' => [
                
            ],
            'factories'  => [
                //\Mobileia\Expressive\Google\Storage::class => \Mobileia\Expressive\Factory\GoogleStorageFactory::class,
                //\Mobileia\Expressive\Middleware\GoogleStorageMiddleware::class => \Mobileia\Expressive\Factory\GoogleStorageMiddlewareFactory::class,
            ],
        ];
    }
}
