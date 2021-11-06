<?php

use \App\Http\Response;
use App\Controller\Admin;


//Rota de login
$objRouter->get('/admin/login',[
    'middlewares' => [
        'required-admin-logout',
    ],
    function($request){
        return new Response(200, Admin\Login::getLogin($request));
    }
]);

//Rota de login (POST)
$objRouter->post('/admin/login',[
    'middlewares' => [
        'required-admin-logout',
    ],
    function($request){
        return new Response(200, Admin\Login::setLogin($request));
    }
]);

//Rota de logout
$objRouter->get('/admin/logout',[
    'middlewares' => [
        'required-admin-login',
    ],
    function($request){
        return new Response(200, Admin\Login::setLogout($request));
    }
]);

