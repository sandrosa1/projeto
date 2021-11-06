<?php

namespace App\Http;

use \Closure;
use \Exception;
use Reflection;
use \ReflectionFunction;
use \App\Http\Middleware\Queue as MiddlewareQueue;

class Router {

    /**
     * URL completa do projeto (raiz)
     *
     * @var string
     */
    private $url = '';

    /**
     * Prefixo de todas as rotas
     *
     * @var string
     */
    private $prefix = '';

    /**
     * Índice de rotas
     *
     * @var array
     */
    private $routes = [];

    /**
     * Instancia de Request
     *
     * @var Request 
     */
    private $request;


    /**
     * Content type padrão do response 'text/html'
     *
     * @var string
     */
    private $contentType = 'text/html';

    /**
     * Método responsável por iniciar a classe
     *
     * @param string $url
     */
    public function __construct($url){
        $this->request = new Request($this);
        $this->url     = $url;
        $this->setPrefix();

    }

    /**
     * Método responsável por alterar o valor do content type
     *
     * @param  string  $contentType  Content type padrão do 
     *
     * @return  self
     */ 
    public function setContentType(string $contentType)
    {
        $this->contentType = $contentType;

    }

    /**
     * Método responsável por definar o prefixo das rotas
     *
     * @return void
     */
    private function setPrefix(){
        //INFORMAÇÕES DA URL ATUAL
        $parseUrl = parse_url($this->url);
     
        //DEFINE O PREFIXO
        $this->prefix = $parseUrl['path'] ?? '';

    }

    /**
     * Método responsavel por adicionar uma rota na classe
     *
     * @param string $method
     * @param string $route
     * @param array $params
     * @return void
     */
    private function addRoute($method, $route, $params = []){

        //VALIDAÇÃO DOS PARÃMETROS
        foreach($params as $key=>$value){
            if($value instanceof Closure){
                $params['controller'] = $value;
                unset($params[$key]);
                continue;
            }
        }

        //Middlewares da rota
        $params['middlewares'] = $params['middlewares'] ?? [];

      
        //VARIAVEIS DA ROTA
        $params['variables'] = [];

        //PADRÃO DE VALÇIDADÇÃO DAS ROTAS
        $patternVariable = '/{(.*?)}/';
        if(preg_match_all($patternVariable, $route, $matches)){
           $route = preg_replace($patternVariable, '(.*?)',$route);
           $params['variables'] = $matches[1];
        }

        //Remove barra no final da rota
        $route = rtrim($route,'/');

        //PADRÃO DE VALIDAÇÃO DA URL
        $patternRoute ='/^'.str_replace('/','\/',$route).'$/';
       
        //ADICIONA A ROTADENTRO DA CLASSE
        $this->routes[$patternRoute][$method] = $params;
       
    }

    /**
     * Método responsável por definir uma rota GET
     *
     * @param string $route
     * @param array $params
     * @return void
     */
    public function get($route, $params = []){

        return $this->addRoute('GET',$route, $params);

    }

    /**
     * Método responsável por definir uma rota POST
     *
     * @param string $route
     * @param array $params
     * @return void
     */
    public function post($route, $params = []){

        return $this->addRoute('POST',$route, $params);

    }

    /**
     * Método responsável por definir uma rota PUT
     *
     * @param string $route
     * @param array $params
     * @return void
     */
    public function put($route, $params = []){

        return $this->addRoute('PUT',$route, $params);

    }

    /**
     * Método responsável por definir uma rota DELETE
     *
     * @param string $route
     * @param array $params
     * @return void
     */
    public function delete($route, $params = []){

        return $this->addRoute('DELETE',$route, $params);

    }

    /**
     * Método responsavel por retornar a uri desconsiderando o prefixo
     *
     * @return string
     */
    public function getUri(){
        //URI DA REQUEST
        $uri = $this->request->getUri();

        //FATIA A URI COM OP PREFIXO
        $xUri = strlen($this->prefix) ? explode($this->prefix, $uri) : [$uri];

        //RETORNA URI SEM PREFIXO
        return rtrim(end($xUri),'/');
                     
    }

    /**
     * Método responsável por retornar os dados da rota atual
     *
     * @return array
     */
    private function getRoute(){
        //URI
        $uri = $this->getUri();
        // echo '<pre>';
        // print_r($uri);
        // echo '</pre>';
    

        //METHOD
        $httpMethod = $this->request->getHttpMethod();
        // echo '<pre>';
        // print_r($httpMethod);
        // echo '</pre>';
        // exit;

       
        //VALIDA AS ROTAS
        foreach($this->routes as $patternRoute=>$methods){
            //VERIFICA SE A ROTA BATE COM O PADRÃO
            if(preg_match($patternRoute, $uri, $matches)){
                //VERIFICA O MÉTODO
                if(isset($methods[$httpMethod])){

                    //REMOVE A PRIMEIRA POSIÇÃO
                    unset($matches[0]);

                    //VARIAVEIS PROCESSADAS
                    $keys = $methods[$httpMethod]['variables'];
                    $methods[$httpMethod]['variables'] = array_combine($keys, $matches);
                    $methods[$httpMethod]['variables']['request'] = $this->request;

                    //RETORNA OS PARÂMETRO DA ROTA
                    return $methods[$httpMethod];

                }
                //MÉTODO NÃO PERMITIDO/DEFINIDO
                throw new Exception("Método não permitido.", 405);
                
            }
        }
        //URL NÃO ENCONTRADA 
        throw new Exception("URL não encontrada.", 404);
        
    }

      /**
     * Método responsável por executar a rota atual
     * @return Response
     */
    public function run(){
        try{
            //OBTÉM A ROTA ATUAL
            $route = $this->getRoute();

            if(!isset($route['controller'])){
                throw new Exception("A URL não pôde ser processada.", 500);
            }

            //ARGUMENTOS DA FUNÇÃO
            $args = [];

              //REFLECTION
            $reflection = new ReflectionFunction($route['controller']);
            foreach ($reflection->getParameters() as $parameter) {

                $name = $parameter->getName();
                $args[$name] = $route['variables'][$name] ?? '';
            }

            //Retorna a execução da fila de middleware
            return(new MiddlewareQueue($route['middlewares'],$route['controller'],$args))->next($this->request);
            

        }catch(Exception $e){
            return new Response($e->getCode(),$e->getMessage());
        }
    }

    /**
     * Método responsável por retornar a URL atual
     *
     * @return string
     */
    public function getCurrentUrl(){
        return $this->url.$this->getUri();
    }

     /**
     * Método responsavel por retornar a url
     *
     * @param string $route
     * @return void
     */
    public function redirect($route){

        //Url
        $url = $this->url.$route;
        // echo '<pre>';
        // print_r($url);
        // echo '</pre>';
        // exit;

        header('Location: '.$url);
        exit;

    }

}