<?php

namespace App\Controller\Srv;

use \App\Utils\View;

class Alert{

    /**
     * Retorna uma mensagem de sucesso
     * @param String $message
     * @return String
     */
    public static function getSuccess($message){

        return View::render('srv/alert/status', [
            'tipo' => 'success',
            'mensagem' => $message
        ]);
    }

    /**
     * Retorna uma mensagem de sucesso
     * @param String $message
     * @return String
     */
    public static function getError($message){

        return View::render('srv/alert/status', [
            'tipo' => 'danger',
            'mensagem' => $message
        ]);
    }
}