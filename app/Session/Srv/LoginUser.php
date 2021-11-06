<?php

namespace App\Session\Srv;

use \App\Session\Sessions;

class LoginUser{


    public $session;

    public function __construct()
    {
        $session = new Sessions();
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

        return $this->session->setSessions($email);

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
    public static function logout(){

        //Inicia a sessão
        self::init();

        //Destroi a sessão
       unset( $_SESSION['srv']['user']);

       return true;

    }

}