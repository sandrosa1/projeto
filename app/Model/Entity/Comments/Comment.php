<?php

namespace App\Model\Entity\Comments;

use \App\Model\Entity\Comments\CommentRating as EntityCommentRating;
use \SandroAmancio\DatabaseManager\Database;


//CLASSE RESPONSÁVEL POR INSERIR UM NOVO COMENTÁRIO SOBRE ALGUMA ATRAÇÃO
class Comment{

        /**
         * 1)
         * Id do comentário
         *
         * @var Integer
         */
        public $idComment;

        /**
         * 2)
         * Id do usuário
         *
         * @var Integer
         */
        public $idUser;

        /**
         * 3)
         * Id da atração
         *
         * @var Integer
         */
        public $idApp;

        /**
         * 4)
         * Id das avaliações do comentário (Se foi util ou não)
         *
         * @var Integer
         */
        public $idCommentRating;

        /**
         * 5)
         * Avaliação do usuário
         *
         * @var Integer
         */
        public $stars;

        /**
         * 6)
         * Descrição do usuário sobre a atração
         *
         * @var String
         */
        public $description;

         /**
          * 7)
         *Data do comentário
         *
         * @var Date
         */
        public $date;


    public function cadastrarComment(){

        $objCommentRating = new EntityCommentRating();

        //POR PADRÃO TODAS CONFIGURAÇÕES RECEBEM 0 inciamente
        $objCommentRating->yesUserful = '0'; 
        $objCommentRating->notUserful = '0'; 

        //Cria o Id de avalição do comentário
        $this->idCommentRating = $objCommentRating->cadastrarCommentRating();

        $this->data = date('Y-m-d H:i:s');
       
        //Inserio os dados do cliete no banco de dados
        $this->idComment = (new Database('comments'))->insert([
            
            'idUser'           => $this->idUser, 
            'idApp'            => $this->idApp, 
            'idCommentRating'  => $this->idCommentRating, 
            'start'            => $this->start, 
            'description'      => $this->description, 
            'data'             => $this->data, 
               
        ]);
        
        //Sucesso
        return true;

    }


    /**
     * Método reponsável por atualizar o cliente
     *
     * @return void
     */
    public function atualizarComment(){


        //Sé o usuário atualizar o comentário, sua avaliação de comentario será zerada
        $$objCommentRating = EntityCommentRating::getCommentRatingById($this->idCommentRating);

        //POR PADRÃO TODAS CONFIGURAÇÕES RECEBEM 0 inciamente
        $objCommentRating->yesUserful = '0'; 
        $objCommentRating->notUserful = '0'; 

        //Cria o Id de avalição do comentário
        $objCommentRating->atualizarCommentRating();

        //Inserio os dados do cliete no banco de dados
        return (new Database('comments'))->update('idComment = '.$this->idComment,[

            'idUser'           => $this->idUser, 
            'idApp'            => $this->idApp, 
            'idCommentRating'  => $this->idCommentRating, 
            'start'            => $this->start, 
            'description'      => $this->description, 
            'data'             => $this->data,
             
        ]);
        
        //Sucesso
        return true;

    }


    /**
     * Método reponsável por deletar um cliente
     *
     * @return void
     */
    public function excluirComment(){

        //Inserio os dados do cliete no banco de dados
        return (new Database('comments'))->delete('idComment = '.$this->idComment);
        
        //Sucesso
        return true;

    }
   /**
     * Método responsável por retornar um cliente pelo idComment
     *
     * @param Intenger $idComment
     * @return Customer
     */
    public static function getUserByIdComment($idComment){

        return self::getComments('idComment = '.$idComment)->fetchObject(self::class);
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
    public static function getComments($where = null, $order = null, $limit = null, $fields = '*'){

        return(new Database('comments'))->select($where, $order, $limit, $fields);
    }




}