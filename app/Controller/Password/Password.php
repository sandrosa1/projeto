<?php

namespace App\Controller\Password;

use \App\Model\Entity\Customer\Customer;

class Password{

    private $db;

    public function __construct()
    {
        $this->db = new Customer();
    }
    /**
     * Criar o hash da senha para salvar no banco de dados
     *
     * @paramString $senha
     * @return String
     */
    public function passwordHash($senha)
    {
        return password_hash($senha, PASSWORD_DEFAULT);
    }

   /**
    * Metódo responsável em verificar se o hash da senha do cliente esta correto
    *
    * @param string $email
    * @param string $password
    * @return boolean
    */
    public function verifyHashCustomer($email,$password)
    {
        $objCustomer = Customer::getCustomerByEmail($email);
    
        if(!password_verify($password,$objCustomer->password)){
          
            return false;
        }

        return true;
    }
}