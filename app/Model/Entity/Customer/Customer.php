<?php

namespace App\Model\Entity\Customer;

use \SandroAmancio\DatabaseManager\Database;

use App\Traits\TraitGetIp;


//CLASSE RESPONSÁVEL PELO CADASTRO DE CLIENTE NO SISTEMA

//RESPONSÁVEL POR UMA INSTÂNCIA DE APP
class Customer{

    /**
     * 1)
     * ID do cliente
     *
     * @var integer
     */
    public $idUser;

    /**
     * 2)
     * Nome de cliente
     *
     * @var string
     */
    public $name;

    
    /**
     * 3)
     * Define o cpf
     *
     * @var string
     */
    public $cpf;

    /**
     * 4)
     * Email do cliente
     *
     * @var string
     */
    public $email;

    /**
     * 4)
     * Telefone do cliente
     *
     * @var string
     */
    public $phone;

    /**
     * 6)
     * Senha do cliente
     *
     * @var string
     */
    public $password;

     /**
      * 7)
     * Data do cadastro
     *
     * @var string
     */
    public $birthDate;

     /**
      * 8)
     * Data de nascimento
     *
     * @var date
     */
    public $createDate;

     /**
      * 9)
     * Define o tipo de permisão do cliénte
     *
     * @var string
     */
    public $permission;

    /**
      * 10)
     * Define se o cliente confirmou o email
     *
     * @var string
     */
    public $status;

     /**
      * 11)
     * Define um toque para validar o cadastro
     *
     * @var string
     */
    public $token;

    private $trait;

    private $dateNow;
    

    public function __construct()
    {
        $this->trait = TraitGetIp::getUserIp();
        $this->dateNow = date("Y-m-d H:i:s");
    }
    /**
     * Método responsável por inserir uma tentativa de login de cliente
     *
     * @return void
     */
    public function insertAttempt(){


        if($this->countAttempt() < 5){
           
            $this->id = (new Database('attempt'))->insert([
                'ip'       => $this->trait, 
                'date'  => $this->dateNow,
             
            ]);
        }
    }

    // #Retorna os dados do usuário
    public function getDataUser($email)
    {
       
        $b = (new Database('customer'))->select('email = "'.$email.'"');
    
        $f=$b->fetch(\PDO::FETCH_ASSOC);
        $r=$b->rowCount();
        return $arrData=[
            "data"=>$f,
            "rows"=>$r
        ];
    }

    #Conta as tentativas
    public function countAttempt()
    {

        $b = (new Database('attempt'))->select('ip = "'.$this->trait.'"');
    
        $r=0;
        while($f=$b->fetch(\PDO::FETCH_ASSOC)){
            if(strtotime($f["date"]) > strtotime($this->dateNow)-1200){
                $r++;
            }
        }
        return $r;
    }

    

       
    #Deleta as tentativas
    public function deleteAttempt()
    {
        return (new Database('attempt'))->delete('ip = "'.$this->trait.'"');
        
    }

    public static function getCustomerToken($email){

        return (new Database('confirmation'))->select('email = "'.$email.'"')->fetchObject(self::class);
    }

    public static function confirmationCad($idUser,$status){


        return (new Database('customer'))->update('idUser = '.$idUser,[

            'status'       => $status,
        ]);

        return true;

    }


    public function insertNewCustomer(){
        
       
        //Inserio os dados do cliete no banco de dados
        $this->idUser = (new Database('customer'))->insert([
            
            'name'         => $this->name, 
            'cpf'          => $this->cpf, 
            'email'        => $this->email,
            'phone'        => $this->phone,
            'password'     => $this->password,
            'birthDate'    => $this->birthDate,  
            'createDate'   => $this->createDate,  
            'permission'   => $this->permission,  
            'status'       => $this->status,  
               
        ]);

        $this->id = (new Database('confirmation'))->insert([
            
            'email'  => $this->email,
            'token'  => $this->token,
           
        ]);
        //Sucesso
        return true;

    }



    /**
     * Método reponsável por atualizar o cliente
     *
     * @return void
     */
    public function updateCustomer(){

        //Inserio os dados do cliete no banco de dados
        return (new Database('customer'))->update('idUser = '.$this->idUser,[

            'name'         => $this->name, 
            'cpf'          => $this->cpf, 
            'email'        => $this->email,
            'phone'        => $this->phone,
            'password'     => $this->password,
            'birthDate'    => $this->birthDate,  
            'createDate'   => $this->createDate,  
            'permission'   => $this->permission,  
            'status'       => $this->status,  
               
             
        ]);
        
        //Sucesso
        return true;

    }


    /**
     * Método reponsável por deletar um cliente
     *
     * @return void
     */
    public function deleteCustomer(){

        //Inserio os dados do cliete no banco de dados
        return (new Database('customer'))->delete('idUser = '.$this->idUser);
        
        //Sucesso
        return true;

    }
   /**
     * Método responsável por retornar um cliente pelo idUser
     *
     * @param Intenger $idUser
     * @return Customer
     */
    public static function getCustomerById($idUser){

        return self::getcustomer('idUser = '.$idUser)->fetchObject(self::class);
    }
   
    /**
     * Método responsável por retotornar um cliente com base em seu email
     *
     * @param string $email
     * @return Customer
     */
    public static function getCustomerByEmail($email){

      
        return (new Database('customer'))->select('email = "'.$email.'"')->fetchObject(self::class);
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
    public static function getcustomer($where = null, $order = null, $limit = null, $fields = '*'){

        return(new Database('customer'))->select($where, $order, $limit, $fields);
    }

  
   
}