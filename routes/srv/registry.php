<?php

use \App\Http\Response;
use App\Controller\Srv;


//Rota de registro de clientes
$objRouter->get('/srv/registry',[
    'middlewares' => [
        // 'required-admin-login'
    ],
    function($request){
        return new Response(200, Srv\Registry::getRegistry($request));
    }
]);

//Rota de cadastro de um novo cliente
$objRouter->get('/srv/registry/new',[
    'middlewares' => [
        // 'required-admin-login'
    ],
    function($request){
        return new Response(200, Srv\Registry::getNewRegistry($request));
    }
]);

//Rota de cadastro de um novo cliente (Post)
$objRouter->post('/srv/registry/new',[
    'middlewares' => [
        'required-admin-login'
    ],
    function($request){
        return new Response(200, Srv\Registry::setNewRegistry($request));
    }
]);

//Rota de edição registro de clientes
$objRouter->get('/srv/registry/{id}/edit',[
    'middlewares' => [
        'required-admin-login'
    ],
    function($request,$id){
        return new Response(200, Srv\Registry::getEditRegistry($request,$id));
    }
]);

//Rota de edição registro de clientes (POST)
$objRouter->post('/srv/registry/{id}/edit',[
    'middlewares' => [
        'required-admin-login'
    ],
    function($request,$id){
        return new Response(200, Srv\Registry::setEditRegistry($request,$id));
    }
]);

//Rota de excluir registro de clientes
$objRouter->get('/srv/registry/{id}/delete',[
    'middlewares' => [
        'required-admin-login'
    ],
    function($request,$id){
        return new Response(200, Srv\Registry::getDeleteRegistry($request,$id));
    }
]);

//Rota de exclusão registro de clientes (POST)
$objRouter->post('/srv/registry/{id}/delete',[
    'middlewares' => [
        'required-admin-login'
    ],
    function($request,$id){
        return new Response(200, Srv\Registry::setDeleteRegistry($request,$id));
    }
]);