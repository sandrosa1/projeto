<?php
namespace App\Http\Middleware;

class Maintenance {

    /**
     * Método resposável por executar o middleware
     *
     * @param  Request $request
     * @param  Closure $next
     * @return Response
     */
    public function handle($request, $next){
        // echo '<pre>';
        // print_r($request);
        // echo '</pre>';
        // exit;

        // echo '<pre>';
        // print_r(getenv('MAINTENANCE'));
        // echo '</pre>';
        // exit;

        //Verifica o estado de maanutenção da página
        if(getenv('MAINTENANCE')== 'true'){
            throw new \Exception("Página em manutenção. ", 200);
        }
        //Executa o proximo nivel do middleware
        return  $next($request);
    }
}