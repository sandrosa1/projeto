<?php

namespace App\Model\Entity\Comments;

use \SandroAmancio\DatabaseManager\Database;


//CLASSE RESPONSÁVEL POR INSERIR UM NOVO COMENTÁRIO SOBRE ALGUMA ATRAÇÃO
class CommentRating{

        /**
         * Id do comentário
         *
         * @var Integer
         */
        public $idCommentRating;

        /**
         * Recebe as avaliacões positivas
         *
         * @var Integer
         */
        public $yesUserful;

        /**
         * Recebe as avaliacões negativas
         *
         * @var Integer
         */
        public $notUserful;
 

    public function cadastrarCommentRating(){

      

        //Inserio os dados do cliete no banco de dados
        $this->idCommentRating = (new Database('commentRatings'))->insert([
            
            'yesUserful'  => $this->yesUserful, 
            'notUserful'   => $this->notUserful, 
        ]);
        
        //Sucesso
        return true;

    }


    /**
     * Método reponsável por atualizar o cliente
     *
     * @return void
     */
    public function atualizarCommentRating(){

        //Inserio os dados do cliete no banco de dados
        return (new Database('commentRatings'))->update('idCommentRating = '.$this->idCommentRating,[

            'yesUserful' => $this->yesUserful, 
            'notUserful' => $this->notUserful,
             
        ]);
        
        //Sucesso
        return true;

    }


    /**
     * Método reponsável por deletar um cliente
     *
     * @return void
     */
    public function excluirCommentRating(){

        //Inserio os dados do cliete no banco de dados
        return (new Database('commentRatings'))->delete('idCommentRating = '.$this->idCommentRating);
        
        //Sucesso
        return true;

    }
   /**
     * Método responsável por retornar um cliente pelo idCommentRating
     *
     * @param Intenger $idCommentRating
     * @return Customer
     */
    public static function getCommentRatingById($idCommentRating){

        return self::getCommentRatings('idCommentRating = '.$idCommentRating)->fetchObject(self::class);
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
    public static function getCommentRatings($where = null, $order = null, $limit = null, $fields = '*'){

        return(new Database('commentRatings'))->select($where, $order, $limit, $fields);
    }




}