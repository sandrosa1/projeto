<?php

use \App\Http\Response;
use App\Controller\Admin;

//Rota de adminstração
$objRouter->get('/admin',[
    'middlewares' => [
        'required-admin-login'
    ],
    function($request){
        echo '<pre>';
        print_r("chegou/admin");
        echo '</pre>';
        exit;
        return new Response(200,Admin\Home::getHome($request));
    }
]);
