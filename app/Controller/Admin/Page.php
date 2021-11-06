<?php

namespace App\Controller\Admin;

use \App\Utils\View;

class Page{

    private static $modules = [
        'home' =>[
            'label' => 'Home',
            'link' => URL.'/admin'
        ],
        'registry' =>[
            'label' => 'Clientes',
            'link' => URL.'/admin/registry'
        ],
        'roots' =>[
            'label' => 'Colaboradores',
            'link' => URL.'/admin/roots'
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
       
        return View::render('admin/page',[

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
            $links .= View::render('admin/menu/link',[
                'label' => $module['label'],
                'link' => $module['link'],
                'current' => $hash == $currentModule ? 'text-danger' : ''
            ]);
        }
        //Retorna a view do menu
        return View::render('admin/menu/box',[
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
        $contentPanel = View::render('admin/panel' ,[
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
            
            $links .= View::render('admin/pagination/link',[
                'page' => $pagina['page'],
                'link' => $link,
                'active' => $pagina['current'] ? 'active' : ''
            ]);

        }
        //Renderiza box de paginação
        return View::render('admin/pagination/box',[
            'links' => $links,
           
        ]);


    }


    
   
}