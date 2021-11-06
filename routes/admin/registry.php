<?php

use \App\Http\Response;
use App\Controller\Admin;


//Rota de registro de clientes
$objRouter->get('/admin/registry',[
    'middlewares' => [
        'required-admin-login'
    ],
    function($request){
        return new Response(200,Admin\Registry::getRegistry($request));
    }
]);

//Rota de cadastro de um novo cliente
$objRouter->get('/admin/registry/new',[
    'middlewares' => [
        'required-admin-login'
    ],
    function($request){
        return new Response(200,Admin\Registry::getNewRegistry($request));
    }
]);

//Rota de cadastro de um novo cliente (Post)
$objRouter->post('/admin/registry/new',[
    'middlewares' => [
        'required-admin-login'
    ],
    function($request){
        return new Response(200,Admin\Registry::setNewRegistry($request));
    }
]);

//Rota de edição registro de clientes
$objRouter->get('/admin/registry/{id}/edit',[
    'middlewares' => [
        'required-admin-login'
    ],
    function($request,$id){
        return new Response(200,Admin\Registry::getEditRegistry($request,$id));
    }
]);

//Rota de edição registro de clientes (POST)
$objRouter->post('/admin/registry/{id}/edit',[
    'middlewares' => [
        'required-admin-login'
    ],
    function($request,$id){
        return new Response(200,Admin\Registry::setEditRegistry($request,$id));
    }
]);

//Rota de excluir registro de clientes
$objRouter->get('/admin/registry/{id}/delete',[
    'middlewares' => [
        'required-admin-login'
    ],
    function($request,$id){
        return new Response(200,Admin\Registry::getDeleteRegistry($request,$id));
    }
]);

//Rota de exclusão registro de clientes (POST)
$objRouter->post('/admin/registry/{id}/delete',[
    'middlewares' => [
        'required-admin-login'
    ],
    function($request,$id){
        return new Response(200,Admin\Registry::setDeleteRegistry($request,$id));
    }
]);