<?php

namespace App\Controller\Api;


class Api{

    /**
     * Método resposável por retornar os detalhes da API
     *
     * @param Request $request
     * @return array
     */
    public static function getDetails($request){
        return[
            'nome' => 'API - SÃO ROQUE E VOCẼ',
            'versao' => 'v1.0.0',
            'autor'  => 'Equipe racs',
            'email'  =>  'desenvolvimento@racs.com.br'
        ];
    }


    // /**
    //  * Método responsável por retornar detalhes da paginação
    //  *
    //  * @param Request $request
    //  * @param Pagination $obPagination
    //  * @return array
    //  */
    // protected static function getPagination($request, $obPagination){

    //     //Query params
    //     $queryParams = $request->getQueryParams();
        
    //     //Paginas
    //     $pages = $obPagination->getPages();


    //     return [
    //         'paginaAtual'       => isset($queryParams['page']) ? (int)$queryParams['page'] : 1,
    //         'QuantidadePaginas' => !empty($pages) ? count($pages) : 1
    //     ];


    }

