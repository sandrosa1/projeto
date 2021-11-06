<?php
namespace App\Http\Middleware;


class Queue {

    /**
     * Mapeamento de middlewares
     *
     * @var array
     */
    private static  $map = [];

    /**
     * Mapeamento de middleware carregado em todas as rotas
     * 
     * @var array $default
     */
    private static $default = [];

    /**
     * Fila de middlewares a serem executados
     *
     * @var array
     */
    private $middlewares = [];

    /**
     * Função de execução do controlador
     *
     * @var Closure
     */
    private $controller;

    /**
     * Argumentos da função do controlador
     *
     * @var array
     */
    private $controllerArgs = [];

    /**
     * Método responsável por construir a classe de fila de middlewares
     *
     * @param array $middlewares
     * @param Closure $controller
     * @param array $controllerArgs
     */
    public function __construct($middlewares, $controller, $controllerArgs){
        $this->middlewares    = array_merge(self::$default, $middlewares );
        $this->controller     = $controller;
        $this->controllerArgs = $controllerArgs;

    }

    /**
     * Método responsável pelo mapeamento de middlewaares
     *
     * @param array $map
     * @return void
     */
    public static function setMap($map){
        self::$map = $map;
    }

    /**
     * Método responsável pelo mapeamento de middlewares padrões
     *
     * @param array $map
     * @return void
     */
    public static function setDefault($default){
        self::$default = $default;
    }

    /**
     * Metodo resposável por executar o proximo nivel da fila de middlewares 
     *
     * @param Request $request
     * @return Response
     */
    public function next($request){
        // echo '<pre>';
        // print_r(self::$map);
        // echo '</pre>';
        // echo '<pre>';
        // print_r($this);
        // echo '</pre>';
        // exit;
      //Verfica se a fila esta vazia
      if(empty($this->middlewares)) return call_user_func_array($this->controller, $this->controllerArgs);
      //die('middlewares');

      //Remove e retorna a primeira posição
      //Middleware
      $middleware = array_shift($this->middlewares);
      
        // echo '<pre>';
        // print_r($middleware);
        // echo '</pre>';
        // exit;
        
      //Verifica o mapeamento não existe
      if(!isset(self::$map[$middleware])){
          throw new \Exception("Problemas ao processar o middleware da requisição", 500);
      }

        // echo '<pre>';
        // print_r($middleware);
        // echo '</pre>';
        // exit;
      
      //Next
      $queue = $this;
      $next = function($request) use ($queue){
          return $queue->next($request);
        };

        // echo '<pre>';
        // print_r($next);
        // echo '</pre>';
        // exit;

        // echo '<pre>';
        // print_r(self::$map[$middleware]);
        // echo '</pre>';
        // exit;

        //Executa o middleware
        return (new self::$map[$middleware])->handle($request, $next);

    }
}