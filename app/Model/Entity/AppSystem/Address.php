<?php

namespace App\Model\Entity\AppSystem;

use \SandroAmancio\DatabaseManager\Database;

//CLASSE RESPONSÁVEL POR CADASTRR ENDEREÇOS NO BANCO DE DADOS
class address{

    /**
     * 1)
     * Id do endereço
     *
     * @var Interger
     */
    public $idAddress;

    /**
     * 2)
     * Cep do local
     *
     * @var String
     */
    public $cep;

    /**
     * 3)
     * Logradouro do local
     *
     * @var String
     */
    public $address;

    /**
     * 4)
     * Número do Local
     *
     * @var String
     */
    public $number;

     /**
      * 5)
     * Número do Local
     *
     * @var String
     */
    public $complement;

    /**
     * 6)
     * Bairro
     *
     * @var String
     */
    public $district;

    /**
     * 7)
     * Cidade
     *
     * @var String
     */
    public $city = 'São Roque';

     /**
      * 8)
     * UF
     *
     * @var String
     */
    public $state = 'SP';



    /**
     * Método reponsável por iniciar o endereço no banco de dados
     *
     * @return void
     */
    public function cadastrarAddress(){
  
        //Inseri os dados zerados de um local
        $this->idAddress = (new Database('adrresses'))->insert([
            
            'cep'        => $this->cep, 
            'address'    => $this->address, 
            'number'     => $this->number, 
            'complement' => $this->complement,    
            'district'   => $this->district,    
            'city'       => $this->city,    
            'state'      => $this->state,    
        ]);
        
        //Sucesso
        return true;

    }

    /**
     * Método reponsável por atualizar os dados do endereço do banco de dados
     *
     * @return void
     */
    public function atualizarAddress(){

        ///Atualiza os dados do endereço de um local
        return (new Database('adrresses'))->update('idAddress = '.$this->idAddress,[

            'cep'        => $this->cep, 
            'address'    => $this->address, 
            'number'     => $this->number, 
            'complement' => $this->complement,    
            'district'   => $this->district,    
            'city'       => $this->city,    
            'state'      => $this->state,  
        
        ]);
        
        //Sucesso
        return true;

    }

    /**
     * Método reponsável por deletar os dados do endereço do banco de dados
     *
     * @return void
     */
    public function excluirAddress(){

        //Deleta os dados do endereço de um local
        return (new Database('adrresses'))->delete('idAddress= '.$this->idAddress);
        
        //Sucesso
        return true;

    }
   /**
     * Método responsável por retornar as endereço pelo idAddress
     *
     * @param Intenger $idAddress
     * @return Customer
     */
    public static function getAddressById($idAddress){

        return self::getAddresses('idAddress = '.$idAddress)->fetchObject(self::class);
    }
   
     /**
     * Método responsavel por retornar todas endereços das empresas ou atrações
     *
     * @param string $where
     * @param string $order
     * @param string $limit
     * @param string $fields
     * @return PDOStatement
     */
    public static function getAddresses($where = null, $order = null, $limit = null, $fields = '*'){

        return(new Database('adrresses'))->select($where, $order, $limit, $fields);
    }



}