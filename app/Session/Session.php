<?php
namespace App\Session;

use App\Model\Entity\Customer\Customer;
use App\Traits\TraitGetIp;

class Sessions{

    private $login;
    private $timeSession = 1200;
    private $timeCanary = 300;

    public function __construct()
    {
        if(session_id() == ''){
            //Os cabeçalios atraveis de arquivos
            ini_set("session.save_handler","files");
            //Abilita uso de cookeis
            ini_set("session.use_cookies",1);
            //So podexser validada e habilata a sessão de cookies
            ini_set("session.use_only_cookies",1);
            //So aceita a validação de cookeis do nosso dominio
            ini_set("session.cookie_domain",DOMAIN);
            //So aceita protocolo HTTP(evita javascript invadir o sistema)
            ini_set("session.cookie_httponly",1);
            //Usa ssl se não estiver local host
            if(DOMAIN != "localhost"){ini_set("session.cookie_secure",1);}
            /*Criptografia das nossas sessions*/
            ini_set("session.entropy_length",512);
            ini_set("session.entropy_file",'/dev/urandom');
            ini_set("session.hash_function",'sha256');
            ini_set("session.hash_bits_per_character",5);
            session_start();
        }
        $this->login = new Customer();
    }

    #Proteger contra roubo de sessão
    public function setSessionCanary($par=null)
    {
        session_regenerate_id(true);
        if($par == null){
            $_SESSION['canary']=[
                "birth" => time(),
                "IP" => TraitGetIp::getUserIp()
            ];
        }else{
            $_SESSION['canary']['birth']=time();
        }
    }

    #Verificar a integridade da sessão
    public function verifyIdSessions()
    {
        if(!isset($_SESSION['canary'])){
            $this->setSessionCanary();
        }
    
        if($_SESSION['canary']['IP'] !== TraitGetIp::getUserIp()){
            $this->destructSessions();
            $this->setSessionCanary();
        }
    
        if($_SESSION['canary']['birth'] < time() - $this->timeCanary){
            $this->setSessionCanary("time");
        }

    }

    #Destruir as sessions existentes
    public function destructSessions()
    {
        foreach (array_keys($_SESSION) as $key) {
            unset($_SESSION[$key]);
        }
    }

    #Setar as sessões do nosso sistema
    public function setSessions($email)
    {
        $this->verifyIdSessions();
        $_SESSION["login"]     = true;
        $_SESSION["time"]      = time();
        $_SESSION["name"]      = $this->login->getDataUser($email)['data']['nome'];
        $_SESSION["email"]     = $this->login->getDataUser($email)['data']['email'];
        $_SESSION["permition"] = $this->login->getDataUser($email)['data']['permissoes'];

    }

    #Validar as páginas internas do sistema
    public function verifyInsideSession()
    {
        $this->verifyIdSessions();
        if(!isset($_SESSION['login']) || !isset($_SESSION['permition']) || !isset($_SESSION['canary'])){
            $this->destructSessions();
            echo "
                <script>
                    alert('Você não está logado');
                    window.location.href='{{URL}}/login';
                </script>
            ";
        }else{
            if($_SESSION['time'] >= time() - $this->timeSession){
                $_SESSION['time']=time();
            }else{
                $this->destructSessions();
                echo "
                <script>
                    alert('Sua sessão expirou. Faça login novamente!');
                    window.location.href='{{URL}}/login';
                </script>
                ";
            }
        }

    }
}