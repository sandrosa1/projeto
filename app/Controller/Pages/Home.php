<?php

namespace App\Controller\Pages;

use \App\Utils\View;
use \App\Model\Entity\Organization;

class Home extends Page{

    public static function getHome(){

        $obOrganization = new Organization;

        // echo '<pre>';
        // print_r($obOrganization);
        // echo '</pre>';
        // exit;

        $content = View::render('pages/home',[
            'name' =>   $obOrganization->name
           
        ]);

        return parent::getPage('HOME - RACS',$content, null);
    }
}