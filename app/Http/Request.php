<?php 

namespace App\Http;

Class Request{

    private $router;

    private $httpMethod;

    private $uri;

    private $queryParams;

    private $postVars;

    private $headers;


    public function __construct($router){
        $this->router = $router;
        $this->queryParams = $_GET ?? [];
        $this->postVars = $_POST ?? [];
        $this->headers = getallheaders();
        $this->httpMethod = $_SERVER['REQUEST_METHOD'] ?? '';
        $this->setUri();
    }

    private function setUri(){
        //URI completas (COM GETS)
        $this->uri = $_SERVER['REQUEST_URI'] ?? '';

        //Remove gets da uri
        $xUri = explode('?',$this->uri);
        $this->uri = $xUri[0];

    }

    public function getRouter(){
        return $this->router;
    }


    /**
     * Get the value of headers
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * Set the value of headers
     */
    public function setHeaders($headers): self
    {
        $this->headers = $headers;

        return $this;
    }

    /**
     * Get the value of httpMethod
     */
    public function getHttpMethod()
    {
        return $this->httpMethod;
    }

    /**
     * Set the value of httpMethod
     */
    public function setHttpMethod($httpMethod): self
    {
        $this->httpMethod = $httpMethod;

        return $this;
    }

    /**
     * Get the value of uri
     */
    public function getUri()
    {
        return $this->uri;
    }

 
    /**
     * Get the value of queryParams
     */
    public function getQueryParams()
    {
        return $this->queryParams;
    }

    /**
     * Set the value of queryParams
     */
    public function setQueryParams($queryParams): self
    {
        $this->queryParams = $queryParams;

        return $this;
    }


    /**
     * Set the value of postVars
     */
    public function setPostVars($postVars): self
    {
        $this->postVars = $postVars;

        return $this;
    }

    /**
     * Get the value of postVars
     */
    public function getPostVars()
    {
        return $this->postVars;
    }

  
}