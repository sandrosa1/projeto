<?php

namespace App\Model\Entity\UserSystem;

use \SandroAmancio\DatabaseManager\Database;

//CLASSE QUE CADASTRA AS CONFIGURAÇÕES DE USUÁRIO DE UM CLIENTE
class UserSettings{

    /**
     * 1)
     * Id de configuraçoes
     *
     * @var Interger
     */
    public $idSetting;

    /**
     * 2)
     * Alerta de novidades
     *
     * @var Boolean
     */
    public $news;


    /**
     * 3)
     * Dicas de pontos turisticos
     *
     * @var Boolean
     */
    public $tourristSpotsTips;

    /**
     * 4)
     * Dicas de restaurantes
     *
     * @var Boolean
     */
    public $restaurantTips;

    /**
     * 5)
     * Alerta de eventos
     *
     * @var Boolean
     */
    public $eventAlert;

    /**
     * 6)
     * Ativa a localização
     *
     * @var Boolean
     */
    public $activateLocation;



    public function cadastrarSetting(){

        //Inserio os dados do cliete no banco de dados
        $this->idSetting = (new Database('userSettings'))->insert([
            
            'news'              => $this->news, 
            'tourristSpotsTips' => $this->tourristSpotsTips, 
            'restaurantTips'    => $this->restaurantTips, 
            'eventAlert'        => $this->eventAlert,
            'activateLocation'  => $this->activateLocation,     
        ]);
        
        //Sucesso
        return true;

    }

    /**
     * Método reponsável por atualizar o cliente
     *
     * @return void
     */
    public function atualizarSetting(){

        //Inserio os dados do cliete no banco de dados
        return (new Database('userSettings'))->update('idSetting = '.$this->idSetting,[

            'news'              => $this->news, 
            'tourristSpotsTips' => $this->tourristSpotsTips, 
            'restaurantTips'    => $this->restaurantTips, 
            'eventAlert'        => $this->eventAlert,
            'activateLocation'  => $this->activateLocation,
             
        ]);
        
        //Sucesso
        return true;

    }

    /**
     * Método reponsável por deletar as configurações pelo
     *
     * @return void
     */
    public function excluirSetting(){

        //Inserio os dados do cliete no banco de dados
        return (new Database('userSettings'))->delete('idSetting = '.$this->idSetting);
        
        //Sucesso
        return true;

    }

   /**
     * Método responsável por retornar as configurações pelo idSetting
     *
     * @param Intenger $idSetting
     * @return Customer
     */
    public static function getSettingByIdSetting($idSetting){

        return self::getSettings('idSetting = '.$idSetting)->fetchObject(self::class);
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
    public static function getSettings($where = null, $order = null, $limit = null, $fields = '*'){

        return(new Database('userSettings'))->select($where, $order, $limit, $fields);
    }




}