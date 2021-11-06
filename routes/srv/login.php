<?php

use \App\Http\Response;
use App\Controller\Srv;


//Rota de login
$objRouter->get('/srv/login',[
    'middlewares' => [
        'required-srv-logout',
    ],
    function($request){
        
        return new Response(200, Srv\Login::getLogin($request));
    }
]);

//Rota de login (POST)
$objRouter->post('/srv/login',[
    'middlewares' => [
        'required-srv-logout',
    ],
    function($request){
        return new Response(200, Srv\Login::setLogin($request));
    }
]);

//Rota de logout
$objRouter->get('/srv/logout',[
    'middlewares' => [
        'required-srv-login',
    ],
    function($request){
        return new Response(200, Srv\Login::setLogout($request));
    }
]);

