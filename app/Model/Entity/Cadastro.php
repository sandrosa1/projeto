<?php

namespace App\Model\Entity;

use \SandroAmancio\DatabaseManager\Database;

class Cadastro{

    public $id;
    public $nome;
    public $mensagem;
    public $data;

    

    public function cadastrar(){

        //Define a dada
        $this->data = date('Y-m-d H:i:s');
        
        //Insere os dados no banco
        $this->id = (new Database('crud'))->insert([
           'nome' => $this->nome,
           'mensagem' => $this->mensagem,
           'data'=> $this->data 
        ]);
        //Sucesso
        return true;
    }

    public static function getCadastro($where = null, $order = null, $limit = null, $fields = '*'){
        return (new Database('crud'))->select($where,$order,$limit,$fields);
    }
}