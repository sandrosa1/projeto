<?php

namespace App\Model\Entity\UserSystem;

use \App\Model\Entity\UserSystem\UserSettings as EntitySetting;
use \SandroAmancio\DatabaseManager\Database;

//CLASSE RESPONSÁVEL POR CADASTRAR USUÁRIOS DO SISTEMA
class User{


    /**
     * 1)
     * ID do usuario
     *
     * @var Integer
     */
    public $idUser;

    /**
     * Primerio nome do usuário
     *
     * @var Integer
     */
    public $firstName;

    /**
     * 2)
     * Segundo nome do usuário
     *
     * @var String
     */
    public $lastName;


    /**
     * 3)
     * Nome que será apresentado no sistema
     *
     * @var String
     */
    public $userName;

    /**
     * 4)
     * Data de aniversário
     *
     * @var Date
     */
    public $birthday;

    /**
     * 5)
     * Email do usuário
     *
     * @var String
     */
    public $email;

    /**
     * 7)
     * Senha do usuário
     *
     * @var String
     */
    public $password;

    /**
     * 8)
     * Data do cadastro
     *
     * @var Date
     */
    public $date;

    /**
     * 9)
     * Termos de responsabilidades
     *
     * @var Boolean
     */
    public $terms;

    /**
     * 10)
     * Configurações do usuário
     *
     * @var Integer
     */
    public $idSetting;

    

    public function cadastrarUser(){

        $objSetting = new EntitySetting();

        //POR PADRÃO TODAS CONFIGURAÇÕES RECEBEM FALSE
        $objSetting ->news              = '0'; 
        $objSetting ->tourristSpotsTips = '0'; 
        $objSetting ->restaurantTips    = '0'; 
        $objSetting ->eventAlert        = '0';
        $objSetting ->activateLocation  = '0';

        $this->idSetting = $objSetting->cadastrarSetting();

        $this->data = date('Y-m-d H:i:s');
       
        //Inserio os dados do cliete no banco de dados
        $this->idUser = (new Database('users'))->insert([
            
            'firstName'  => $this->firstName, 
            'lastName'   => $this->lastName, 
            'userName'   => $this->userName, 
            'birthday'   => $this->birthday,
            'email'      => $this->email,  
            'password'   => $this->password,  
            'data'       => $this->data,  
            'term'       => $this->term,  
            'idSetting'  => $this->idSetting,  
               
        ]);
        
        //Sucesso
        return true;

    }


    /**
     * Método reponsável por atualizar o cliente
     *
     * @return void
     */
    public function atualizarUser(){

        //Inserio os dados do cliete no banco de dados
        return (new Database('users'))->update('idUser = '.$this->idUser,[

            'firstName'  => $this->firstName, 
            'lastName'   => $this->lastName, 
            'userName'   => $this->userName, 
            'birthday'   => $this->birthday,
            'email'      => $this->email,  
            'password'   => $this->password,
             
        ]);
        
        //Sucesso
        return true;

    }


    /**
     * Método reponsável por deletar um cliente
     *
     * @return void
     */
    public function excluirUser(){

        //Inserio os dados do cliete no banco de dados
        return (new Database('users'))->delete('idUser = '.$this->idUser);
        
        //Sucesso
        return true;

    }
   /**
     * Método responsável por retornar um cliente pelo idUser
     *
     * @param Intenger $idUser
     * @return Customer
     */
    public static function getUserById($idUser){

        return self::getUsers('idUser = '.$idUser)->fetchObject(self::class);
    }
   
    /**
     * Método responsável por retotornar um usuário com base em seu userName
     *
     * @param String $userName
     * @return User
     */
    public static function getUserByEmail($email){

      
        return (new Database('users'))->select('email = "'.$email.'"')->fetchObject(self::class);
    }

     /**
     * Método responsavel por retornar depoimentos
     *
     * @param string $where
     * @param string $order
     * @param string $limit
     * @param string $fields
     * @return PDOStatement
     */
    public static function getUsers($where = null, $order = null, $limit = null, $fields = '*'){

        return(new Database('users'))->select($where, $order, $limit, $fields);
    }

}