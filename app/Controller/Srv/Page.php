<?php

namespace App\Controller\Srv;

use \App\Utils\View;

class Page{

    private static $modules = [
        'home' =>[
            'label' => 'Home',
            'link' => URL.'/srv'
        ],
        'registry' =>[
            'label' => 'Clientes',
            'link' => URL.'/srv/registry'
        ],
        'roots' =>[
            'label' => 'Colaboradores',
            'link' => URL.'/srv/roots'
        ],
    ];

    /**
     * Método resposável por retornar o conteúdo (view) da estrutura genérica de página do paineil
     *
     * @param  String $title
     * @param  String $content
     * @return String
     */
    public static function getPage($title, $content ){
       
        return View::render('srv/page',[

            'title'   => $title,
            'content' => $content,
          
         
        ]);
    }

    /**
     *Renderiza a view do menu
     *
     * @param String $currentModule
     * @return String
     */
    private static function getMenu($currentModule){
        //Links do menu
        $links = '';
        //Itera os links do menu e compara modulo atual
        foreach(self::$modules as $hash=>$module){
            $links .= View::render('srv/menu/link',[
                'label' => $module['label'],
                'link' => $module['link'],
                'current' => $hash == $currentModule ? 'text-danger' : ''
            ]);
        }
        //Retorna a view do menu
        return View::render('srv/menu/box',[
            'links' => $links
        ]);
    }

     /**
     * Método resposável por renderiza a view do paineil com conteúdos dinâmicos
     *
     * @param  String $title
     * @param  String $content
     * @param  String $currentModule 
     * @return String
     */
    public static function getPanel($title, $content, $currentModule ){
       
        //Renderiza a view do painel
        $contentPanel = View::render('srv/panel' ,[
            'menu' => self::getMenu($currentModule),
            'content' => $content
        ]);
        //Retorna a pagina renderizada
        return self::getPage($title,$contentPanel);
    }

    public static function getPagination($request, $objPagination){

        $paginas = $objPagination->getPages();
       
        //Verifica a quantidade de paginas
        if(count($paginas) <= 1) return '';

        $links = '';
        //URL atual (SEM GETS)
        $url = $request->getRouter()->getCurrentUrl();
       
        //Valores de GET
        $queryParams = $request->getQueryParams();
        
        //Renderiza os links
        foreach ($paginas as $pagina) {
            
            //Altera a pagina
            $queryParams['page'] = $pagina['page'];

            //Link 
            $link = $url.'?'.http_build_query($queryParams);
            
            $links .= View::render('srv/pagination/link',[
                'page' => $pagina['page'],
                'link' => $link,
                'active' => $pagina['current'] ? 'active' : ''
            ]);

        }
        //Renderiza box de paginação
        return View::render('srv/pagination/box',[
            'links' => $links,
           
        ]);


    }


    
   
}