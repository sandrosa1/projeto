<?php

namespace App\Controller\Pages;

use \App\Utils\View;
use \App\Model\Entity\Organization;

class Page{

    private static function getHeader(){
        return View::render('pages/header');
    }


    private static function getFooter(){

        $objOrganization = new Organization();
        $footer = View::render('pages/footer',[
            'endereco' => $objOrganization->address,
            'site' => $objOrganization->site,
        ]);
        return View::render('pages/footer',$footer);

    }
   

    public static function getPage($title,$content){

        return View::render('pages/page',[
            'title' => $title,
            'header' => self::getHeader(),
            'content' => $content,
            'footer' => self::getFooter(),

        ]);
    }
}