<?php

namespace App\Model\Entity\AppSystem;

use \SandroAmancio\DatabaseManager\Database;

//CLASSE RESPONSÁVEL PELO CADASTRO NO BANCO DE DADOS DE CLIENTES DO SISTEMA
class Customer{
    /**
     * 1)
     * ID do cliente
     *
     * @var Integer
     */
    public $idCustomer;
    /**
     * 2)
     * Primeiro nome do responsável pelas informações que seram inseridas
     *
     * @var String
     */
    public $firstName;
    /**
     * 3)
     * Sobrenome do responsável
     *
     * @var String
     */
    public $lastName;
    /**
     * 4)
     * Nome de usuário (apelido)
     *
     * @var String
     */
    public $userName;
    /**
     * 5)
     * Data de aniversário
     *
     * @var Date
     */
    public $birthday;
    /**
     * 6)
     * Email do cliente
     *
     * @var String
     */
    public $email;
    /**
     * 7)
     * Telefone do cliente
     *
     * @var String
     */
    public $phone;
    /**
     * 8)
     * Nome da empresa ou negócio do cliente
     *
     * @var String
     */
    public $businessName;
    /**
     * 9)
     * Senha do cliente
     *
     * @var String
     */
    public $password;
    /**
     * 10)
     * Termos de responsábilidades
     *
     * @var Boolean
     */
    public $terms; 
    /**
     * 11)
     * Data do cadastro
     *
     * @var Date
     */
    public $data;
    /**
     * 12)
     * Data do cadastro
     *
     * @var Integer
     */
    public $type;
    /**
     * Método responsável por cadastrar um novo cliente
     *
     * @return void
     */
    public function cadastrarCustomer(){

        $this->data = date('Y-m-d H:i:s');
       
        //Inseri os dados do cliente no banco de dados
        $this->idCustomer = (new Database('customers'))->insert([
            
            'firstName'     => $this->firstName, 
            'lastName'      => $this->lastName, 
            'userName'      => $this->userName, 
            'birthday'      => $this->birthday, 
            'email'         => $this->email, 
            'phone'         => $this->phone, 
            'businessName'  => $this->businessName, 
            'password'      => $this->password, 
            'data'          => $this->data, 
            'terms'         => $this->terms,          
            'type'         => $this->type,          
        ]);
        
        //Sucesso
        return true;

    }


    /**
     * Método reponsável por atualizar o cliente
     *
     * @return void
     */
    public function atualizarCustomer(){

        //Atualiza os dados do cliente no banco de dados
        return (new Database('customers'))->update('idCustomer = '.$this->idCustomer,[

            'firstName'     => $this->firstName, 
            'lastName'      => $this->lastName, 
            'userName'      => $this->userName, 
            'birthday'      => $this->birthday, 
            'email'         => $this->email, 
            'phone'         => $this->phone, 
            'businessName'  => $this->businessName, 
            'password'      => $this->password, 
            'type'         => $this->type,         
        ]);
       
    }

    /**
     * Método reponsável por deletar um cliente do banco de dados
     *
     * @return void
     */
    public function excluirCustomer(){

        //Exclui os dados do cliente no banco de dados
        return (new Database('customers'))->delete('idCustomer = '.$this->idCustomer);
        
     
    }
    /**
     * Método responsável por retornar um cliente pelo idCustomer
     *
     * @param Intenger $idCustomer
     * @return Customer
     */
    public static function getCustomerById($idCustomer){

        return self::getCustomers('idCustomer = '.$idCustomer)->fetchObject(self::class);
    }
   
    /**
     * Método responsável por retornar um cliente com base em seu email
     *
     * @param String $email
     * @return User
     */
    public static function getCustomerByEmail($email){

      
        return (new Database('customers'))->select('email = "'.$email.'"')->fetchObject(self::class);
    }

    /**
     * Método responsável por retornar todos os clientes clientes
     *
     * @param string $where
     * @param string $order
     * @param string $limit
     * @param string $fields
     * @return PDOStatement
     */
    public static function getCustomers($where = null, $order = null, $limit = null, $fields = '*'){

        return(new Database('customers'))->select($where, $order, $limit, $fields);
    }

}