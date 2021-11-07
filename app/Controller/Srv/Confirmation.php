<?php

namespace App\Controller\Srv;

use App\Model\Entity\AppSystem\Customer;
use \App\Utils\View;
use \App\Model\Entity\Customer\Customer as EntityCustomer;




class Confirmation extends Page {

    /**
    * Metodo que verifica a validação do cadastro
    *
    * @param Request $request
    * @return String
    */
    public static function getConfirmation($request){

    $getVars = $request->getQueryParams();

    $email = $getVars['email'];
    $validateToken = $getVars['token'];
    $status ="active";

    $confirmation = new EntityCustomer;

    //Verifica se existe o cadastro
    $objCustomer = $confirmation->getCustomerByEmail($email);
    $objCustomerToken = $confirmation->getCustomerToken($email);
        
    if(!$objCustomer instanceof EntityCustomer){
        echo '<pre>';
        print_r('nao e uma instancia');
        echo '</pre>';
        exit;
    }

    if($objCustomerToken->token !=  $validateToken ||  $validateToken == ''){

        echo '<pre>';
        print_r('token invalido');
        echo '</pre>';
        exit;
    }

   $confirmation->confirmationCad($objCustomer->idUser, $status );

 

    //Conteúde da pagina de login
    $content = View::render('srv/login',[

        'status' => '<span class="srv-c-4 m-3">Validado com sucesso</span>'

    ]);

    return parent::getPage('SRV - Login',$content);

   }

}