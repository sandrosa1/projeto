<?php
namespace App\Http\Middleware;

use \App\Session\Admin\LoginRoot as SessionAdminLoginRoot;

class RequireAdminLogin{


     /**
     * Método resposável por executar o middleware
     *
     * @param  Request $request
     * @param  Closure $next
     * @return Response
     */
    public function handle($request, $next){

        //Verifica se o usuário está logado
        if(!SessionAdminLoginRoot::isLogged()){ 
            $request->getRouter()->redirect('/admin/login');
        }

        //Continua a execução
        return $next($request);
        
    }


    

}