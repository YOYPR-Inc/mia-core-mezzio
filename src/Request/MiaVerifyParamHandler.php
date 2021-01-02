<?php namespace Mia\Core\Request;

class MiaVerifyParamHandler implements \Psr\Http\Server\MiddlewareInterface
{
    /**
     *
     * @var array
     */
    protected $params = array();
    
    public function __construct($params)
    {
        // verificar que sea un array
        if(is_array($params)){
            $this->params = $params;
        }
    }
    
    public function process(\Psr\Http\Message\ServerRequestInterface $request, \Psr\Http\Server\RequestHandlerInterface $handler): \Psr\Http\Message\ResponseInterface
    {
        // recorrer los parametros
        foreach($this->params as $key){
            $value = $this->getParam($request, $key, null);
            if($value === null){
                return new \Mia\Core\Diactoros\MiaJsonErrorResponse(-1, 'No se ha enviado un parametro obligatorio.');
            }
        }
        return $handler->handle($request);
    }
    /**
     * Obtener parametro sin importar de donde provenga.
     */
    protected function getParam(\Psr\Http\Message\ServerRequestInterface $request, $key, $default = null)
    {
        // Obtener parametros
        $params = $request->getParsedBody();
        // verificar si fue enviado
        if(array_key_exists($key, $params)){
            return $params[$key];
        }
        // Obtener Querys
        $querys = $request->getQueryParams();
        if(array_key_exists($key, $querys)){
            return $querys[$key];
        }
        return $default;
    }
}