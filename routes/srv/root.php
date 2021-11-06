<?php

use \App\Http\Response;
use App\Controller\Srv;


//Rota de registro de colaborador
$objRouter->get('/srv/roots',[
    'middlewares' => [
        //'required-srv-login'
    ],
    function($request){
        return new Response(200,Srv\Root::getRoots($request));
    }
]);

//Rota de cadastro de um novo colaborador
$objRouter->get('/srv/roots/new',[
    'middlewares' => [
        //'required-srv-login'
    ],
    function($request){
        return new Response(200,Srv\Root::getNewRoot($request));
    }
]);

//Rota de cadastro de um novo colaborador (Post)
$objRouter->post('/srv/roots/new',[
    'middlewares' => [
        //'required-srv-login'
    ],
    function($request){
        return new Response(200,Srv\Root::setNewRoot($request));
    }
]);

//Rota de edição registro de colaborador
$objRouter->get('/srv/roots/{id}/edit',[
    'middlewares' => [
        //'required-srv-login'
    ],
    function($request,$id){
        return new Response(200,Srv\Root::getEditRoot($request,$id));
    }
]);

//Rota de edição registro de colaborador (POST)
$objRouter->post('/srv/roots/{id}/edit',[
    'middlewares' => [
        //'required-srv-login'
    ],
    function($request,$id){
        return new Response(200,Srv\Root::setEditRoot($request,$id));
    }
]);

//Rota de excluir registro de colaborador
$objRouter->get('/srv/roots/{id}/delete',[
    'middlewares' => [
        //'required-srv-login'
    ],
    function($request,$id){
        return new Response(200,Srv\Root::getDeleteRoot($request,$id));
    }
]);

//Rota de exclusão registro de colaborador (POST)
$objRouter->post('/srv/roots/{id}/delete',[
    'middlewares' => [
        //'required-srv-login'
    ],
    function($request,$id){
        return new Response(200,Srv\Root::setDeleteRoot($request,$id));
    }
]);