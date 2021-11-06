<?php
//Caminho alterado
require __DIR__ .'/../vendor/autoload.php';

use \App\Utils\View;
use \SandroAmancio\DotEnv\Environment;
use SandroAmancio\DatabaseManager\Database;
use \App\Http\Middleware\Queue as MiddlewareQueue;

//Carrega variaveis de ambiente
Environment::load(__DIR__ .'/../');


Database::config(
    getenv('DB_HOST'),
    getenv('DB_NAME'),   
    getenv('DB_USER'), 
    getenv('DB_PASS'), 
    getenv('DB_PORT'), 
);

//Defini uma url (Será provisoria)
define('URL', getenv('URL'));
//Define o dominio
define("DOMAIN",$_SERVER["HTTP_HOST"]);

View::init([
    'URL' => URL,
    'DOMAIN' => DOMAIN
]);

//Define o mapeamento de middlewares
MiddlewareQueue::setMap([
    'maintenance'           => \App\Http\Middleware\Maintenance::class,
    'required-admin-logout' => \App\Http\Middleware\RequireAdminLogout::class,
    'required-admin-login'  => \App\Http\Middleware\RequireAdminLogin::class,
    'required-srv-logout'   => \App\Http\Middleware\RequireSrvLogout::class,
    'required-srv-login'    => \App\Http\Middleware\RequireSrvLogin::class
]);

//Define o mapeamento de middlewares padrões (Executa em todas as rotas)
MiddlewareQueue::setDefault([
    'maintenance'  
]);