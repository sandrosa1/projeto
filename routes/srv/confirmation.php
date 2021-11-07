<?php

use \App\Http\Response;
use App\Controller\Srv;

//Rota de adminstração
$objRouter->get('/srv/confirmation',[
    'middlewares' => [  
        
    ],
    function($request){
        
        return new Response(200, Srv\Confirmation::getConfirmation($request));
    }
]);
