<?php

use \App\Http\Response;
use App\Controller\Pages;

$objRouter->get('/',[
    'middlewares' => [
        'maintenance'
    ],
    function(){
        return new Response(200,Pages\Home::getHome());
    }
]);

$objRouter->get('/sobre',[
    function(){
        return new Response(200,Pages\About::getAbout());
    }
]);
//Rota de get
$objRouter->get('/cadastro',[
    function($request){
        return new Response(200,Pages\Cadastro::getCadastro($request));
    }
]);
//Rota de insert
$objRouter->post('/cadastro',[
    function($request){
        return new Response(200,Pages\Cadastro::insertRegistration($request));
    }
]);





