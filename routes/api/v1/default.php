<?php

use \App\Http\Response;
use \App\Controller\Api;

//Rota raiz
$objRouter->get('/api/v1',[
    function($request){
        return new Response(200,Api\Api::getDetails($request),'application/json');
    }
]);