<?php

use MatthiasMullie\Minify;

$minify = filter_input(INPUT_GET, "minify", FILTER_VALIDATE_BOOLEAN);

if($_SERVER['SERVER_NAME'] == 'localhost' || $minify){

    $minCSS = new Minify\CSS();
    // $minCSS->add(dirname(__DIR__, 1)."/app/assets/css/materialize.css");

    $cssDir = scandir(dirname(__DIR__, 1)."/app/assets/css/");

   
    foreach($cssDir as $cssItem){
        $cssFile = dirname(__DIR__, 1)."/app/assets/css/${cssItem}";
       
        if(is_file($cssFile) && pathinfo($cssFile)["extension"] == "css"){
           
            $minCSS->add($cssFile);
        }
            
    }

    $minCSS->minify(dirname(__DIR__, 1)."/app/assets/styles.min.css");

  
    $minJS = new Minify\JS();
    // $minJS->add(dirname(__DIR__, 1)."/app/assets/js/materialize.js");
    // $minJS->add(dirname(__DIR__, 1)."/app/assets/js/date.js");
    // $minJS->add(dirname(__DIR__, 1)."/app/assets/js/jquery-3.6.0.js");
    // $minJS->add(dirname(__DIR__, 1)."/app/assets/js/vanilla-masker.js");
    $jsDir = scandir(dirname(__DIR__, 1)."/app/assets/js/");
    foreach($jsDir as $jsItem){
        $jsFile = dirname(__DIR__, 1)."/app/assets/js/${jsItem}";
        if(is_file($jsFile) && pathinfo($jsFile)["extension"] == "js"){
            $minJS->add($jsFile);
        }
        
    }
    $minJS->minify(dirname(__DIR__, 1)."/app/assets/javascripts.min.js");

}
