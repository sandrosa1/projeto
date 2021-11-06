<?php

namespace App\Controller\Admin;

use \App\Utils\View;
use \App\Model\Entity\Root\Root;
use \App\Session\Admin\LoginRoot as SessionAdminLoginRoot;


class Login extends Page{

    /**
     * Método responsável por retornar a rederização da paǵina de login
     *
     * @param Request $request
     * @param string $errorMessager
     * @return string
     */
    public static function getLogin($request, $errorMessager = null) {

        //Status
        $status = !is_null($errorMessager) ? Alert::getSuccess($errorMessager) : '';
        //Conteúdo da página de login
        $content = View::render('admin/login',[
            'status' => $status
           
        ]);

        //Retona a página completa
         return parent::getPage('Admin - RACS',$content);
       
    }

    /**
     * Método resposavel por definir o login do usuario
     *
     * @param Request $request
     * @return void
     */
    public static function setLogin($request){

 
        //Post vars
        $postVars  = $request->getPostVars();
        $email     = $postVars['email'] ?? '';
        $userName  = $postVars['userName'] ?? '';
        $password  = $postVars['password'] ?? '';

        
        //Busca usuário pelo email
        $objRoot = Root::getRootByEmail($email);
        
           
        if (!$objRoot instanceof Root){
            return self::getLogin($request,  'Dados Inválidos');
        }
       
       

        //Validado password e usuário
        if(!password_verify($password,$objRoot->password) or ($userName != $objRoot->userName)){
            return self::getLogin($request,  'Dados Inválidos2');

        }

        //Cria a sessão de login
        SessionAdminLoginRoot::login($objRoot);

        
        //Redireciona o usuário para a home do admin
        $request->getRouter()->redirect('/admin');
    }

    /**
     * Método reponsável por delogar o usuário
     *
     * @param Request $request
     * @return void
     */
    public static function setLogout($request){

        //Destroi a sessão de login
        SessionAdminLoginRoot::logout();

        //Redireciona o usuário para a página de login
        $request->getRouter()->redirect('/admin/login');
    }

}