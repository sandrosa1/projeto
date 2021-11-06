<?php

namespace App\Model\Entity\AppSystem;

use \SandroAmancio\DatabaseManager\Database;

//CLASSE RESPONSÁVEL PELO CADASTRO DE HORAIO DE FUNCIONAMENTO DA EMPRESA OU EVENTO NO BANCO DE DADOS
class Statistic{

    /**
     * 1)
     * Id service hours
     *
     * @var Integer
     */
    public $idStatistic;

    /**
     * 2)
     * Média das availiações (Soma das estrela divido pelos avaliadores)
     *
     * @var Float
     */
    public $percentagemOfStars;

    /**
     * 3)
     * Soma das estrelas
     *
     * @var Integer
     */
    public $totalStars;

    /**
     * 4)
     * Custo medio da atração
     *
     * @var Integer
     */
    public $averageCost;

    /**
     * 5)
     * Total de avaliadores
     *
     * @var Integer
     */
    public $totalRating;

   
    /**
     * 
     * Método reponsável por cadastrar e iniciar as estatísticas no banco de dados
     *
     * @return void
     */
    public function cadastrarStatistic(){

       
        //Inseri os dados estatísticos de um local
        $this->idStatistic = (new Database('statistics'))->insert([
            
            'percentagemOfStars'   => $this->percentagemOfStars, 
            'totalStars'           => $this->totalStars, 
            'totalRating'          => $this->totalRating, 
            'averageCost'          => $this->averageCost,    
        ]);
        
        //Sucesso
        return true;

    }

    /**
     * Método reponsável por atualizar os dados estatísticos do banco de dados
     *
     * @return void
     */
    public function atualizarStatistic(){

        ///Atualiza os dados estatísticos de um local
        return (new Database('statistics'))->update('idStatistic = '.$this->idStatistic,[

            'percentagemOfStars'   => $this->percentagemOfStars, 
            'totalStars'           => $this->totalStars, 
            'totalRating'          => $this->totalRating, 
            'averageCost'          => $this->averageCost, 
        
        ]);
        
        //Sucesso
        return true;

    }

    /**
     * Método reponsável por deletar os dados estatísticos do banco de dados
     *
     * @return void
     */
    public function excluirStatistic(){

        //Deleta os dados estatísticos de um local
        return (new Database('statistics'))->delete('idStatistic= '.$this->idStatistic);
        
        //Sucesso
        return true;

    }
   /**
     * Método responsável por retornar as estatísticas pelo idStatistic
     *
     * @param Intenger $idStatistic
     * @return Customer
     */
    public static function getStatisticById($idStatistic){

        return self::getStatistics('idStatistic = '.$idStatistic)->fetchObject(self::class);
    }
   
     /**
     * Método responsavel por retornar todas estatísticas das empresas ou atrações
     *
     * @param string $where
     * @param string $order
     * @param string $limit
     * @param string $fields
     * @return PDOStatement
     */
    public static function getStatistics($where = null, $order = null, $limit = null, $fields = '*'){

        return(new Database('statistics'))->select($where, $order, $limit, $fields);
    }

}