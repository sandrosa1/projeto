<?php

namespace App\Controller\Srv;

use \App\Utils\View;
use \App\Model\Entity\Customer\Customer as EntityCustomer;
use \App\Controller\Password\Password as PasswordHash;
use \App\Session\Srv\LoginUser as SessionSrvLoginUser;


class Login extends Page{


    private $erro=[];

    private $login;

    private $tentativas;

    
   
    public function __construct()
    {
        $this->login= new EntityCustomer();
    }
    public function getErro()
    {
        return $this->erro;
    }

    
    public function setErro($erro)
    {
        array_push($this->erro,$erro);
    }

      /**
     * Validar se os campos desejados foram preenchidos
     *
     * @param Post $par
     * @return boolean
     */
    public function validateFields($par)
    {
        $i=0;
        foreach ($par as $key => $value){
            if(empty($value)){
                $i++;
            }
        }
        if($i==0){
            return true;
        }else{
            $this->setErro("Preencha todos os dados!");
            return false;
        }
    }

     /**
     *  Validação se o dado é um email
     *
     * @param string $par
     * @return boolean
     */
    public function validateEmail($par)
    {
        if(filter_var($par, FILTER_VALIDATE_EMAIL)){
            return true;
        }else{
            $this->setErro("Email inválido!");
            return false;
        }
    }

    /**
     * #Validar se o email existe no banco de dados (action null para cadastro)
     *
     * @param string $email
     * @param string $action
     * @return boolean
     */
    public function validateIssetEmail($email,$action=null)
    {
        $userEmail = EntityCustomer::getCustomerByEmail($email);

        if($action==null){
            if($userEmail > 0){
                $this->setErro("Email já cadastrado!");
                return false;
            }else{
                return true;
            }
        }else{
            if($userEmail > 0){
                return true;
            }else{
                $this->setErro("Email não cadastrado!");
                return false;
            }
        }
    }


      #Validação das tentativas
    public function validateAttemptLogin()
    {
        if($this->login->countAttempt() >= 5){
            $this->setErro("Você realizou mais de 5 tentativas!");
            $this->tentativas = true;
            return false;
        }else{
            $this->tentativas = false;
            return true;
        }
    }

    #Método de validação de confirmação de email
    public function validateUserActive($email)
    {
        $customer=$this->login->getDataUser($email);

        if($customer["data"]["status"] == "confirmation"){

            if(strtotime($customer["data"]["dataCriacao"])<= strtotime(date("Y-m-d H:i:s"))-432000){

                $this->setErro("Ative seu cadastro pelo link do email");

                return false;
            }else{

                return true;
            }
        }else{

            return true;
        }
    }

       #Validação final do login
       public function validateFinalLogin($email)
       {
          
       }
  
  

  


    /**
     * Método responsável por retornar a rederização da paǵina de login
     *
     * @param Request $request
     * @param string $errorMessager
     * @return string
     */
    public static function getLogin($request) {

      
        $content = View::render('srv/login',[
        
        ]);

        //Retona a página completa
         return parent::getPage('SRV - Login',$content);
       
    }

    // /**
    //  * #Verificar se o captcha está correto
    //  *
    //  * @param string $captcha
    //  * @param float $score
    //  * @return void
    //  */
    public function validateCaptcha($captcha,$score=0.5)
    {
      
        $secretkey = getenv('SECRETKEY');
      
        $return=file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret={$secretkey}&response={$captcha}");
        $response = json_decode($return);
        if($response->success == true && $response->score >= $score){
            return true;
        }else{
            $this->setErro("Captcha Inválido! Atualize a página e tente novamente.");
            return false;
        }
    }


      #Verificação da password digitada com o hash no banco de dados
      public function validateSenha($email,$password)
      {
           $hash = new PasswordHash();
          if($hash->verifyHashCustomer($email,$password)){

              return true;
          }else{
              $this->setErro("Usuário ou Senha Inválidos!");

              return false;
          }
      }


    private static function responseError($validate){

        $validate->login->insertAttempt();
        $arrResponse=[
            "retorno" => "erro",
            "erros"   => $validate->getErro(),
            "tentativas" => $validate->tentativas
        ];

        return json_encode($arrResponse);
    }



    /**
     * Método resposavel por definir o login do usuario
     *
     * @param Request $request
     * @return void
     */
    public static function setLogin($request){

 
        $dadosLogin = [];
        $postVars = $request->getPostVars();
        $dadosLogin[0] = $email               = $postVars['email'] ?? '';
        $dadosLogin[1] = $password            = $postVars['password'] ?? '';
        $dadosLogin[2] = $gRecaptchaResponse  = $postVars['g-recaptcha-response'] ?? '';

        $validate = new Login();

        if(!$validate->validateFields($dadosLogin))
        {
            return self:: responseError($validate);
        }
        if(!$validate->validateEmail($email)){

            return self:: responseError($validate);
        }
        if(!$validate->validateIssetEmail($email,"login")){

            return self:: responseError($validate);
        }
        if(!$validate->validateSenha($email,$password)){

            return self:: responseError($validate);
        }
        // if(!$validate->validateCaptcha($gRecaptchaResponse)){

        //     return self:: responseError($validate);
        // }

        if(!$validate->validateUserActive($email)){

            return self:: responseError($validate);
        }
        if(!$validate->validateAttemptLogin()){

            return self:: responseError($validate);
        }
       
       
        if(count($validate->getErro()) >0){
            $validate->login->insertAttempt();
            $arrResponse=[
               "retorno" => "erro",
               "erros"   => $validate->getErro(),
               "tentativas" => $validate->tentativas
           ];

        }else{
            $validate->login->deleteAttempt();
            //$validate->session->setSessions($email);
            $arrResponse=[
               "retorno" => 'success',
               "page" => 'areaRestrita',
               "tentativas"   => $validate->tentativas
           ];
           echo '<pre>';
           print_r($arrResponse);
           echo '</pre>';
           exit;
        }

        
        //return json_encode($arrResponse);

        
        // //Busca usuário pelo email
        // $objRoot = Customer::getCustomerByEmail($email);
        
           
        // if (!$objRoot instanceof Root){
        //     return self::getLogin($request,  'Dados Inválidos');
        // }
       
       

        //Validado password e usuário
        // if(!password_verify($password,$objRoot->password) or ($userName != $objRoot->userName)){
        //     return self::getLogin($request,  'Dados Inválidos2');

        // }

        // //Cria a sessão de login
        // SessionSrvLoginUser::login($objRoot);

        
        // //Redireciona o usuário para a home do admin
        // $request->getRouter()->redirect('/srv');
    }

    /**
     * Método reponsável por delogar o usuário
     *
     * @param Request $request
     * @return void
     */
    public static function setLogout($request){

        //Destroi a sessão de login
        SessionSrvLoginUser::logout();

        //Redireciona o usuário para a página de login
        $request->getRouter()->redirect('/srv/login');
    }

}