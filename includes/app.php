<?php
//Caminho alterado
require __DIR__ .'/../vendor/autoload.php';

use \App\Utils\View;
use \SandroAmancio\DotEnv\Environment;
use SandroAmancio\DatabaseManager\Database;
use \App\Communication\Email;
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

define('EMAIL_HOST',getenv('EMAIL_HOST'));
define('EMAIL_USER',getenv('EMAIL_USER'));   
define('EMAIL_PASS',getenv('EMAIL_PASS')); 
define('EMAIL_SECURE',getenv('EMAIL_SECURE')); 
define('EMAIL_PORT',getenv('EMAIL_PORT')); 
define('EMAIL_CHARSET',getenv('EMAIL_CHARSET')); 
define('EMAIL_FORM_EMAIL',getenv('EMAIL_FORM_EMAIL')); 
define('EMAIL_FROM_NAME',getenv('EMAIL_FROM_NAME'));


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