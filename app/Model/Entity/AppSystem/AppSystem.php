<?php

namespace App\Model\Entity\AppSystem;

use \SandroAmancio\DatabaseManager\Database;
use \App\Model\Entity\AppSystem\Customer as EntityCustomer;
use \App\Model\Entity\AppSystem\Option as EntityOption;
use \App\Model\Entity\AppSystem\Address as EntityAddress;
use \App\Model\Entity\AppSystem\Statistic as EntityStatistic;
use \App\Model\Entity\AppSystem\ServiceHour as EntityServiceHour;


class AppSystem{

    /**
     * 1)
     * Id da aplicação no sistema
     *
     * @var Integer
     */
    public $idAppSystem;
    /**
     * 2)
     * Id do responsável pela empresa ou negócio
     *
     * @var Integer
     */
    public $idCustomer;
    /**
     * 3)
     * Ramo ou Tipo de negócio /Pontos turistico/Hospedagems/Gastronomia/Eventos/Hospitais/Mecânicos/Bancos/Farmácias/Mercados/Posto de combustiveis/Comercio em geral
     *
     * @var String
     */
    public $branch;
    /**
     * 4)
     * Nome do estabelecimento ou atração
     *
     * @var String
     */
    public $placeName;
    /**
     * 5)
     * local onde Imagem principal está armazenada
     *
     * @var String
     */
    public $img1;
    /**
     * 6)
     * local onde Imagem 2 está armazenada
     *
     * @var String
     */
    public $img2;
    /**
     * 7)
     * local onde Imagem 3 está armazenada
     *
     * @var String
     */
    public $img3;
    /**
     * 8)
     * local onde Imagem 4 está armazenada
     *
     * @var String
     */
    public $img4;
    /**
     * 9)
     * Breve descrição do local(500 caracteris)
     *
     * @var String
     */
    public $locationDescription;
    /**
     * 10)
     * Site do local
     *
     * @var String
     */
    public $site;
    /**
     * 11)
     * Telefone do local
     *
     * @var String
     */
    public $locationPhone;
    /**
     * 12)
     * Id de onde está localizado os dados de Endereço
     *
     * @var Integer
     */
    public $idAddress;
    /**
     * 13)
     * Id de onde está os dados do horario de funcionamento
     *
     * @var Integer
     */
    public $idServiceHour;
    /**
     * 14)
     * Id de onde está os dados de estaticas do local
     *
     * @var Integer
     */
    public $idStatistic;
    /**
     * 15)
     * Id de onde está os dados das opções disponiveis do local
     *
     * @var Integer
     */
    public $idOption;
   
    /**
     * 16)
     * Data de cadastro
     *
     * @var Date
     */
    public $date;
   

    /**
     * Método responsável por cadastrar negocio
     *
     * @return void
     */
    public function cadastrarAppSystem(){

        //CRIA UM ENTIDADE ENDEREÇO COM OS ATRIBUTOS VAZIOS
        $objAddress = new EntityAddress();

        $objAddress->cep        = ''; 
        $objAddress->address    = ''; 
        $objAddress->number     = ''; 
        $objAddress->complement = '';    
        $objAddress->district   = '';    
        $objAddress->city       = '';    
        $objAddress->state      = ''; 
        //Recebe o id da entidade criada
        $this->idAddress = $objAddress->cadastrarAddress();

        //CRIA UM ENTIDADE HORARIO DE SERVIÇO COM OS ATRIBUTOS VAZIOS
        $objServiceHour = new EntityServiceHour();

        $objServiceHour->timeInTheWeekp  = ''; 
        $objServiceHour->timeOnSaturdays = ''; 
        $objServiceHour->timeOnSunday    = ''; 
        $objServiceHour->timeOnHoliday   = '';    
        $objServiceHour->exceptions      = ''; 
        //Recebe o id da entidade criada   
        $this->idServiceHour = $objServiceHour->cadastrarServiceHour();

        //CRIA UM ENTIDADE ESTATÍSTICAS COM OS ATRIBUTOS ZERADOS
        $objStatistic = new EntityStatistic();

        $objStatistic->percentagemOfStars = '0'; 
        $objStatistic->totalStars         = '0'; 
        $objStatistic->totalRating        = '0'; 
        $objStatistic->averageCost        = '0'; 
        //Recebe o id da entidade criada  
        $this->idStatistic = $objStatistic->cadastrarStatistic();

        //CRIA UM ENTIDADE OPÇÕES DO LOCAL COM OS ATRIBUTOS FALSOS
        $objOption = new EntityOption();

        $objOption->breakfast       = '0'; 
        $objOption->pool            = '0'; 
        $objOption->airConditioning = '0'; 
        $objOption->parking         = '0'; 
        $objOption->snack           = '0'; 
        $objOption->academy         = '0'; 
        $objOption->wifi            = '0'; 
        $objOption->accessibillity  = '0'; 
        $objOption->pub             = '0';
        $objOption->pets            = '0';
        $objOption->animals         = '0'; 
        $objOption->trail           = '0'; 
        $objOption->bikeTrail       = '0'; 
        $objOption->nature          = '0'; 
        $objOption->toys            = '0'; 
        $objOption->iceCreanPalor   = '0'; 
        $objOption->winery          = '0'; 
        $objOption->drink           = '0'; 
        $objOption->data            = '0'; 
        $objOption->restaurant      = '0'; 
        $objOption->liveMusic       = '0'; 
        $objOption->typicalFoods    = '0'; 
        $objOption->clothes         = '0'; 
        $objOption->shoes           = '0'; 
        $objOption->technology      = '0'; 
        $objOption->convenience     = '0';    
        //Recebe o id da entidade criada
        $this->idOption = $objOption->cadastrarOption();

        //Registra a data de criação do cadastro do sistema
        $this->date = date('Y-m-d H:i:s');
  
        //Inseri os dados do cliente no banco de dados
        $this->idAppSystem = (new Database('appSystems'))->insert([
            
            'idCustomer'          => $this->idCustomer, 
            'branch'              => $this->branch, 
            'placeName'           => $this->placeName, 
            'img1'                => $this->img1, 
            'img2'                => $this->img2, 
            'img3'                => $this->img3, 
            'img4'                => $this->img4, 
            'locationDescription' => $this->locationDescription, 
            'site'                => $this->site, 
            'locationPhone'       => $this->locationPhone, 
            'idAddress'           => $this->idAddress, 
            'idServiceHour'       => $this->idServiceHour, 
            'idStatistic'         => $this->idStatistic, 
            'idOption'            => $this->idOption,          
            'date'                => $this->date,          
        ]);
        
        //Sucesso
        return true;

    }


    /**
     * Método reponsável por atualizar o cliente
     *
     * @return void
     */
    public function atualizarAppSystem(){

        //Atualiza os dados do cliente no banco de dados
        return (new Database('appSystems'))->update('idAppSystem = '.$this->idAppSystem,[

            'branch'              => $this->branch, 
            'placeName'           => $this->placeName,
            'img1'                => $this->img1, 
            'img2'                => $this->img2, 
            'img3'                => $this->img3, 
            'img4'                => $this->img4,  
            'locationDescription' => $this->locationDescription, 
            'site'                => $this->site, 
            'locationPhone'       => $this->locationPhone,  
        ]);
       
    }

    /**
     * Método reponsável por deletar um cliente do banco de dados
     *
     * @return void
     */
    public function excluirAppSystem(){

        //Exclui os dados do cliente no banco de dados
        return (new Database('appSystems'))->delete('idAppSystem = '.$this->idAppSystem);
        
     
    }
    /**
     * Método responsável por retornar um cliente pelo idAppSystem
     *
     * @param Intenger $idAppSystem
     * @return Customer
     */
    public static function getAppSystemById($idAppSystem){

        return self::getAppSystems('idAppSystem = '.$idAppSystem)->fetchObject(self::class);
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
    public static function getAppSystems($where = null, $order = null, $limit = null, $fields = '*'){

        return(new Database('appSystems'))->select($where, $order, $limit, $fields);
    }

}