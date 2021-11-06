<?php

namespace App\Model\Entity\AppSystem;

use \SandroAmancio\DatabaseManager\Database;

//CLASSE RESPONSÁVEL PELO CADASTRO DE HORAIO DE FUNCIONAMENTO DA EMPRESA OU EVENTO NO BANCO DE DADOS
class ServiceHour{

    /**
     * 1)
     * Id service hours
     *
     * @var Integer
     */
    public $idServiceHour;

    /**
     * 2)
     * Horário na Semana Ex: "8:00 as 17:00" ou "0" Para não abre
     *
     * @var String
     */
    public $timeInTheWeek;

    /**
     * 3)
     * Horário aos Sábado Ex: "8:00 as 17:00" ou "0" Para não abre
     *
     * @var String
     */
    public $timeOnSaturdays;

    /**
     * 4)
     * Horário aos domingos Ex: "8:00 as 17:00" ou "0" Para não abre
     *
     * @var String
     */
    public $timeOnSunday;

    /**
     * 5)
     * Horário nos Feridos Ex: "8:00 as 17:00" ou "0" Para não abre
     *
     * @var String
     */
    public $timeOnHoliday;

     /**
      * 6)
     * Para um breve relato do tipo Ex: "Aberto 24hs"  ou "Plantão nos feriados"
     *
     * @var String
     */
    public $exceptions;

     /**
     * Método reponsável por cadastrar um horário de funcionamento
     *
     * @return void
     */
    public function cadastrarServiceHour(){

       
        //Inseri os dados do horário de funcionamento de um local
        $this->idServiceHour = (new Database('serviceHours'))->insert([
            
            'timeInTheWeek'   => $this->timeInTheWeek, 
            'timeOnSaturdays' => $this->timeOnSaturdays, 
            'timeOnSunday'    => $this->timeOnSunday, 
            'timeOnHoliday'   => $this->timeOnHoliday,
            'exceptions'      => $this->exceptions,
               
        ]);
        
        //Sucesso
        return true;

    }

    /**
     * Método reponsável por atualizar o horário de funcionamento
     *
     * @return void
     */
    public function atualizarServiceHour(){

        //Atualiza os dados do horário de funcionamento de um local
        return (new Database('serviceHours'))->update('idServiceHour = '.$this->idServiceHour,[

            'timeInTheWeek'   => $this->timeInTheWeek, 
            'timeOnSaturdays' => $this->timeOnSaturdays, 
            'timeOnSunday'    => $this->timeOnSunday, 
            'timeOnHoliday'   => $this->timeOnHoliday,
            'exceptions'      => $this->exceptions,
        ]);
        
        //Sucesso
        return true;

    }


    /**
     * Método reponsável por deletar os horários de funcionamento
     *
     * @return void
     */
    public function excluirServiceHour(){

        //Deleta os dados do horário de funcionamento de um local
        return (new Database('serviceHours'))->delete('idServiceHour= '.$this->idServiceHour);
        
        //Sucesso
        return true;

    }
   /**
     * Método responsável por retornar un horário de funcionamento pelo idServiceHour
     *
     * @param Intenger $idServiceHour
     * @return Customer
     */
    public static function getServiceHourById($idServiceHour){

        return self::getServiceHours('idServiceHour = '.$idServiceHour)->fetchObject(self::class);
    }
   
     /**
     * Método responsavel por retornar todos horários de funcionamento
     *
     * @param string $where
     * @param string $order
     * @param string $limit
     * @param string $fields
     * @return PDOStatement
     */
    public static function getServiceHours($where = null, $order = null, $limit = null, $fields = '*'){

        return(new Database('serviceHours'))->select($where, $order, $limit, $fields);
    }


}