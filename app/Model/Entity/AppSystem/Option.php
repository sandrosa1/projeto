<?php

namespace App\Model\Entity\AppSystem;

use \SandroAmancio\DatabaseManager\Database;

//CLASSE RESPONSÁVEL PELO CADASTRO DOS ATRIBUTOS DE UM LOCAL (O QUE ELE POSSUI)
class Option{

    /**
     * 1)
     * ID do opcões
     *
     * @var Integer
     */
    public $idOption;

    /**
     * 2)
     * Tem café da manhá
     *
     * @var Boolean
     */
    public $breakfast;

    /**
     * 3)
     * Tem piscina
     *
     * @var Boolean
     */
    public $pool;

    /**
     * 4)
     * Tem ar condicionado
     *
     * @var Boolean
     */
    public $airConditioning;

    /**
     * 5)
     * Tem estacionamento
     *
     * @var Boolean
     */
    public $parking;

    /**
     * 6)
     * Tem refeição no local
     *
     * @var Boolean
     */
    public $snack;

    /**
     * 7)
     * Tem academia
     *
     * @var Boolean
     */
    public $academy;

    /**
     * 8)
     * Tem wi-fi
     *
     * @var Boolean
     */
    public $wifi;

    /**
     * 9)
     * Tem acessibilidade no local
     *
     * @var Boolean
     */
    public $accessibillity;

    /**
     * 10)
     * Tem bar
     *
     * @var Boolean
     */
    public $pub;

    /**
     * 11)
     * Permite entrada de animais de estimação
     *
     * @var Boolean
     */
    public $pets;

    /**
     * 12)
     * Tem animais no local
     *
     * @var Boolean
     */
    public $animals;

    /**
     * 13)
     * Tem trilha no local
     *
     * @var Boolean
     */
    public $trail;

    /**
     * 14)
     * Trilha ou pista para bicicleta
     *
     * @var Boolean
     */
    public $bikeTrail;

    /**
     * 15)
     * Tem natureza no local
     *
     * @var Boolean
     */
    public $nature;

    /**
     *16)
     * Tem brinquedos no local
     *
     * @var Boolean
     */
    public $toys;

    /**
     * 17)
     * Tem sorveteria
     *
     * @var Boolean
     */
    public $iceCreanPalor;

    /**
     * 18)
     * Tem adéga de vinho
     *
     * @var Boolean
     */
    public $winery;

    /**
     * 19)
     * Vende bebidas alcóolicas
     *
     * @var Boolean
     */
    public $drink;

    /**
     * 20)
     * Tem restaurante no local
     *
     * @var Boolean
     */
    public $restaurant;

    /**
     * 21)
     * Tem rmusica ao vivo
     *
     * @var Boolean
     */
    public $liveMusic;

    /**
     * 22)
     * Tem musica ao vivo
     *
     * @var Boolean
     */
    public $typicalFoods;

    /**
     * 23)
     * Venda de vestuário
     *
     * @var Boolean
     */
    public $clothes;

    /**
     * 24)
     * Venda de calçados
     *
     * @var Boolean
     */
    public $shoes;

    /**
     * 24)
     * Venda de cequpamentos tecnologicos
     *
     * @var Boolean
     */
    public $technology;

    /**
     * 24)
     * loja de conveniencia no local
     *
     * @var Boolean
     */
    public $convenience;

    



    /**
     * Método responsável por cadastrar as opções de um local (Por padrão receberam false de inicio)
     *
     * @return void
     */
    public function cadastrarOption(){

        //Inseri os dados das opcões no banco de dados
        $this->idOption = (new Database('options'))->insert([
            
            'breakfast'       => $this->breakfast, 
            'pool'            => $this->pool, 
            'airConditioning' => $this->airConditioning, 
            'parking'         => $this->parking, 
            'snack'           => $this->snack, 
            'academy'         => $this->academy, 
            'wifi'            => $this->wifi, 
            'accessibillity'  => $this->accessibillity, 
            'pub'             => $this->pub,
            'pets'            => $this->pets,
            'animals'         => $this->animals, 
            'trail'           => $this->trail, 
            'bikeTrail'       => $this->bikeTrail, 
            'nature'          => $this->nature, 
            'toys'            => $this->toys, 
            'iceCreanPalor'   => $this->iceCreanPalor, 
            'winery'          => $this->winery, 
            'drink'           => $this->drink, 
            'data'            => $this->data, 
            'restaurant'      => $this->restaurant, 
            'liveMusic'       => $this->liveMusic, 
            'typicalFoods'    => $this->typicalFoods, 
            'clothes'         => $this->clothes, 
            'shoes'           => $this->shoes, 
            'technology'      => $this->technology, 
            'convenience'     => $this->convenience, 

        ]);
        
        //Sucesso
        return true;

    }


    /**
     * Método reponsável por atualizar as opcões
     *
     * @return void
     */
    public function atualizarOption(){

        //Atualiza os dados das opcões no banco de dados
        return (new Database('options'))->update('idOption = '.$this->idOption,[

            'breakfast'       => $this->breakfast, 
            'pool'            => $this->pool, 
            'airConditioning' => $this->airConditioning, 
            'parking'         => $this->parking, 
            'snack'           => $this->snack, 
            'academy'         => $this->academy, 
            'wifi'            => $this->wifi, 
            'accessibillity'  => $this->accessibillity, 
            'pub'             => $this->pub,
            'pets'            => $this->pets,
            'animals'         => $this->animals, 
            'trail'           => $this->trail, 
            'bikeTrail'       => $this->bikeTrail, 
            'nature'          => $this->nature, 
            'toys'            => $this->toys, 
            'iceCreanPalor'   => $this->iceCreanPalor, 
            'winery'          => $this->winery, 
            'drink'           => $this->drink, 
            'data'            => $this->data, 
            'restaurant'      => $this->restaurant,
            'liveMusic'       => $this->liveMusic,
            'typicalFoods'    => $this->typicalFoods,
            'clothes'         => $this->clothes, 
            'shoes'           => $this->shoes, 
            'technology'      => $this->technology, 
            'convenience'     => $this->convenience, 
        ]);
       
    }

    /**
     * Método reponsável por deletar as opcões do banco de dados
     *
     * @return void
     */
    public function excluirOption(){

        //Exclui os dados das opcões no banco de dados
        return (new Database('options'))->delete('idOption = '.$this->idOption);
        
     
    }
    /**
     * Método responsável por retornar as opcões de um local pelo idOption
     *
     * @param Intenger $idOption
     * @return Customer
     */
    public static function getOptionById($idOption){

        return self::getOptions('idOption = '.$idOption)->fetchObject(self::class);
    }
   
    /**
     * Método responsável por retornar todos as opções cadastradas
     *
     * @param string $where
     * @param string $order
     * @param string $limit
     * @param string $fields
     * @return PDOStatement
     */
    public static function getOptions($where = null, $order = null, $limit = null, $fields = '*'){

        return(new Database('options'))->select($where, $order, $limit, $fields);
    }

}