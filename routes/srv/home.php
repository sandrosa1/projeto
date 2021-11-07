<?php

use \App\Http\Response;
use App\Controller\Srv;

//Rota de adminstração
$objRouter->get('/srv',[
    'middlewares' => [  
        'required-srv-login'
    ],
    function($request){
      
        return new Response(200, Srv\Home::getHome($request));
    }
    
]);
