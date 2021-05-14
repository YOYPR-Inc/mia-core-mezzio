<?php namespace Mia\Core;

use Symfony\Component\Yaml\Yaml;

class Core 
{
    const SWAGGER_FILE = 'public/swagger/index.html';
    const EMAIL_EDITOR_FILE = 'public/mia-mail/main.b9c1413ef3ca7e605cce.js';
    /**
     * Inicializa y configura lo necesario
     */
    public static function install(\Psr\Container\ContainerInterface $container)
    {
        // Verify if localhost
        if($_SERVER['SERVER_NAME'] != '0.0.0.0'){
            return;
        }
        // Gets all variables in app.yaml
        $vars = Yaml::parseFile('app.yaml');
        // Get API URl
        $apiUrl = $vars['env_variables']['API_URL'];
        // Replace URL in Swagger
        self::replace(self::SWAGGER_FILE, 'https://petstore.swagger.io/v2/swagger.json', $apiUrl . '/swagger/swagger.json');
        // Replace URL in Email Editor
        self::replace(self::EMAIL_EDITOR_FILE, 'https://vulnwatch-development.ts.r.appspot.com/', $apiUrl . '/');
    }

    public static function replace($filePath, $search, $replace)
    {
        // Open the file
        $content = file_get_contents($filePath);
        // Replace string
        $content = str_replace($search, $replace, $content);
        // Save file
        file_put_contents($filePath, $content);
    }
}