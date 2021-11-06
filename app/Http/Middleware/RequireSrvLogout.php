<?php
namespace App\Http\Middleware;

use \App\Session\Srv\LoginUser as SessionSrvLoginUser;

class RequireSrvLogout{


     /**
     * Método resposável por executar o middleware
     *
     * @param  Request $request
     * @param  Closure $next
     * @return Response
     */
    public function handle($request, $next){

        //Verifica se o usuário está logado
        if(SessionSrvLoginUser::isLogged()){     
            $request->getRouter()->redirect('/srv');
        }
        //Continua a execução
        return $next($request);
        
    }

}