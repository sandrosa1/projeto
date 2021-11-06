<?php

use \App\Http\Response;
use App\Controller\Admin;


//Rota de registro de colaborador
$objRouter->get('/admin/roots',[
    'middlewares' => [
        'required-admin-login'
    ],
    function($request){
        return new Response(200,Admin\Root::getRoots($request));
    }
]);

//Rota de cadastro de um novo colaborador
$objRouter->get('/admin/roots/new',[
    'middlewares' => [
        'required-admin-login'
    ],
    function($request){
        return new Response(200,Admin\Root::getNewRoot($request));
    }
]);

//Rota de cadastro de um novo colaborador (Post)
$objRouter->post('/admin/roots/new',[
    'middlewares' => [
        'required-admin-login'
    ],
    function($request){
        return new Response(200,Admin\Root::setNewRoot($request));
    }
]);

//Rota de edição registro de colaborador
$objRouter->get('/admin/roots/{id}/edit',[
    'middlewares' => [
        'required-admin-login'
    ],
    function($request,$id){
        return new Response(200,Admin\Root::getEditRoot($request,$id));
    }
]);

//Rota de edição registro de colaborador (POST)
$objRouter->post('/admin/roots/{id}/edit',[
    'middlewares' => [
        'required-admin-login'
    ],
    function($request,$id){
        return new Response(200,Admin\Root::setEditRoot($request,$id));
    }
]);

//Rota de excluir registro de colaborador
$objRouter->get('/admin/roots/{id}/delete',[
    'middlewares' => [
        'required-admin-login'
    ],
    function($request,$id){
        return new Response(200,Admin\Root::getDeleteRoot($request,$id));
    }
]);

//Rota de exclusão registro de colaborador (POST)
$objRouter->post('/admin/roots/{id}/delete',[
    'middlewares' => [
        'required-admin-login'
    ],
    function($request,$id){
        return new Response(200,Admin\Root::setDeleteRoot($request,$id));
    }
]);