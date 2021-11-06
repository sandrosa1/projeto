<?php
namespace SandroAmancio\DotEnv;

/**
 * Reponsável por carregar o arquivo ENV
 */
class Environment{

    /**
     * Método responsável por carregar as variaveis de ambiente do projeto
     *
     * @param string $dir Caminho absoluto do arquivo .env
     * @return void
     */
    public static function load($dir){
        //Verifica se o arquivo .env existe
        if(!file_exists($dir.'/.env')) return false;

        $lines = file($dir.'/.env');
        foreach ($lines as $line){
            putenv(trim($line));
        }

    }

}