<?php

namespace App\Controller\Pages;

use \App\Utils\View;
use \App\Model\Entity\Organization;

class About extends Page{

    public static function getAbout(){

        $objOrganization = new Organization;

        // echo '<pre>';
        // print_r($objOrganization);
        // echo '</pre>';
        // exit;

        $content = View::render('pages/about',[
            'name' =>   $objOrganization->name,
            'description' =>  $objOrganization->description,
            'endereco' => $objOrganization->address,
            'mission' => $objOrganization->mission,
            'vision' => $objOrganization->vision,
            'values' => $objOrganization->values,
            'site' => $objOrganization->site,
        ]);

      

        return parent::getPage('SOBRE - RACS',$content);
    }
}