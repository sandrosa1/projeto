<?php

namespace App\Session\Admin;

class LoginRoot{

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
    public static function login($objRoot){


        //Inicia a sessão
        self::init();
        
        //Define a sessão do usuário
        $_SESSION['admin']['root'] = [
          'idRoot' =>$objRoot->idRoot,
          'userName' => $objRoot->userName,
          'email' => $objRoot->email,  
          'type' => $objRoot->type  
        ];

        //Sucesso
        return true;

    }

    public static function isLogged(){

        //Inicia a sessão
        self::init();

        return isset($_SESSION['admin']['root']['idRoot']);
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
       unset( $_SESSION['admin']['root']);

       return true;

    }

}