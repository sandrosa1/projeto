<?php

namespace App\Model\Entity\Root;

use \SandroAmancio\DatabaseManager\Database;

//CLASSE RESPONSÁVEL PELO CADASTRO DE ADMINISTRADORES DO SISTEMA
class Root{

    /**
     * 1)
     * ID do usuario
     *
     * @var Integer
     */
    public $idRoot;

    /**
     * 2)
     * Nome de usuario
     *
     * @var String
     */
    public $rootName;

    /**
     * 3)
     * Um apelido para ser apresentado
     *
     * @var String
     */
    public $userName;

    /**
     * 4)
     * Define o tipo de usúario
     *
     * @var Integer
     */
    public $type;

    /**
     * 5)
     * Email do usuário
     *
     * @var String
     */
    public $email;

    /**
     * 6)
     * Senha do Usuário
     *
     * @var String
     */
    public $password;

     /**
      * 7)
     * Data do cadastro
     *
     * @var Date
     */
    public $date;


    public function cadastrarRoot(){

        $this->date = date('Y-m-d H:i:s');
       
        //Inserio os dados do cliete no banco de dados
        $this->idRoot = (new Database('roots'))->insert([
            
            'rootName'    => $this->rootName, 
            'userName'    => $this->userName, 
            'email'       => $this->email,
            'password'    => $this->password,
            'date'        => $this->date,  
               
        ]);
        
        //Sucesso
        return true;

    }


    /**
     * Método reponsável por atualizar o cliente
     *
     * @return void
     */
    public function atualizarRoot(){

        //Inserio os dados do cliete no banco de dados
        return (new Database('roots'))->update('idRoot = '.$this->idRoot,[

            'rootName'  => $this->rootName, 
            'userName'  => $this->userName, 
            'type'      => $this->type, 
            'email'     => $this->email,
            'password'  => $this->password,
             
        ]);
        
        //Sucesso
        return true;

    }


    /**
     * Método reponsável por deletar um cliente
     *
     * @return void
     */
    public function excluirRoot(){

        //Inserio os dados do cliete no banco de dados
        return (new Database('roots'))->delete('idRoot = '.$this->idRoot);
        
        //Sucesso
        return true;

    }
   /**
     * Método responsável por retornar um cliente pelo idRoot
     *
     * @param Intenger $idRoot
     * @return Customer
     */
    public static function getRootById($idRoot){

        return self::getRoots('idRoot = '.$idRoot)->fetchObject(self::class);
    }
   
    /**
     * Método responsável por retotornar um usuário com base em seu email
     *
     * @param String $email
     * @return User
     */
    public static function getRootByEmail($email){

      
        return (new Database('roots'))->select('email = "'.$email.'"')->fetchObject(self::class);
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
    public static function getRoots($where = null, $order = null, $limit = null, $fields = '*'){

        return(new Database('roots'))->select($where, $order, $limit, $fields);
    }

}