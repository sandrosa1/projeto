<?php

namespace App\Controller\Admin;

use \App\Utils\View;



class Home extends Page{

    /**
     * Renderiza o conteúdo da Home Administradora
     *
     * @param Request $request
     * @return String
     */
   public static function getHome(){
       //Conteúdo da HOME
       $content = View::render('admin/modules/home/index',[]);

       return parent::getPanel('HOME - Admin', $content,'home');

   }
}