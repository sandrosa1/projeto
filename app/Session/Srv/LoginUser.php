<?php

namespace App\Session\Srv;

use \App\Session\Session;

class LoginUser{


    public $session;

    public function __construct()
    {
        $this->session = new Session();
    }

       /**
     * Get the value of session
     */
    public function getSession()
    {
        return $this->session;
    }

    /**
     * Set the value of session
     */
    public function setSession($session): self
    {
        $this->session = $session;

        return $this;
    }

    

    /**
     * Método responsável por iniciar a sessão
     *
     * @return void
     */
    private static function init(){

        //Verifica se a sessão não está ativa
        if(session_status() != PHP_SESSION_ACTIVE){
            session_start();
        }
    }

    /**
     * Método responsável por criar o login 
     *
     * @param User $objRoot
     * @return Boolean
     */
    public function login($email){

        //$session = new Session();

        return $this->getSession()->setSessions($email);

    }

    public static function isLogged(){

        //Inicia a sessão
        self::init();

        return isset($_SESSION['srv']['user']['idUser']);
    } 

    /**
     * Método responsável por executar o logout do adminitrador
     *
     * @return boolean
     */
    public static  function logout(){


     return Session::destructSessions();

    }


 
}