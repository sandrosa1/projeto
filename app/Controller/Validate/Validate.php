<?php
namespace App\Controller\Validate;

use ZxcvbnPhp\Zxcvbn;

class Validate{

    private $erro=[];
    
   
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
     * @param String $par
     * @return Boolean
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
        $userEmail=$this->cadastro->getIssetEmail($email);

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

    /**
     * #Validação se o dado é uma data
     *
     * @param date $par
     * @return boolean
     */
    public function validateData($par)
    {
        $data=\DateTime::createFromFormat("d/m/Y",$par);
        if(($data) && ($data->format("d/m/Y") === $par)){
            return true;
        }else{
            $this->setErro("Data inválida!");
            return false;
        }
    }


    
    //https://gist.github.com/rafael-neri/ab3e58803a08cb4def059fce4e3c0e40
    /**
     * Validação se é um cpf real
     *
     * @param string $cpf
     * @return boolean
     */
    function validateCPF($cpf) {
    
        // Extrai somente os números
        $cpf = preg_replace( '/[^0-9]/is', '', $cpf );
        
        // Verifica se foi informado todos os digitos corretamente
        if (strlen($cpf) != 11) {
            $this->setErro("Cpf Inválido!");
            return false;
        }

        // Verifica se foi informada uma sequência de digitos repetidos. Ex: 111.111.111-11
        if (preg_match('/(\d)\1{10}/', $cpf)) {
            $this->setErro("Cpf Inválido!");
            return false;
        }

        // Faz o calculo para validar o CPF
        //https://campuscode.com.br/conteudos/o-calculo-do-digito-verificador-do-cpf-e-do-cnpj
        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf[$c] * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf[$c] != $d) {
                $this->setErro("Cpf Inválido!");
                return false;
            }
        }
        return true;

    }
    /**
     * Verificar se a senha é igual a confirmação de senha
     *
     * @param string $senha
     * @param string $senhaConf
     * @return boolean
     */
    public function validateConfSenha($senha,$senhaConf)
    {
        if($senha === $senhaConf){
            return true;
        }else{
            $this->setErro("Senha diferente de confirmação de senha!");
            return false;
        }
    }

    /**
     *  Verificar a força da senha(par==null para cadastro)
     *
     * @param string $senha
     * @param string $par
     * @return boolean
     */
    public function validateStrongSenha($senha,$par=null)
    {
        $zxcvbn=new Zxcvbn();
        $strength = $zxcvbn->passwordStrength($senha);
        // echo $strength['score'].'<br>';

        if($par==null){
            if($strength['score'] >= 3){
                return true;
            }else{
                $this->setErro("Utilize uma senha mais forte!");
            }
        }else{
            /*login*/
        }
    }


    // /**
    //  * #Verificar se o captcha está correto
    //  *
    //  * @param string $captcha
    //  * @param float $score
    //  * @return void
    //  */
    // public function validateCaptcha($captcha,$score=0.5)
    // {
    //     $return=file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".SECRETKEY."&response={$captcha}");
    //     $response = json_decode($return);
    //     if($response->success == true && $response->score >= $score){
    //         return true;
    //     }else{
    //         $this->setErro("Captcha Inválido! Atualize a página e tente novamente.");
    //         return false;
    //     }
    // }

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
        $user=$this->login->getDataUser($email);
        if($user["data"]["status"] == "confirmation"){
            if(strtotime($user["data"]["dataCriacao"])<= strtotime(date("Y-m-d H:i:s"))-432000){
                $this->setErro("Ative seu cadastro pelo link do email");
                return false;
            }else{
                return true;
            }
        }else{
            return true;
        }
    }

    #Validação final do cadastro
    public function validateFinalCad($arrVar,$table)
    {
        if(count($this->getErro())>0){
            $arrResponse=[
                "retorno" => "erro",
                "erros"   => $this->getErro()
            ];
        }else{
            $arrResponse=[
                "retorno" => "success",
                "erros"   => null
            ];
            $this->cadastro->insertCad($arrVar);
        }
        return json_encode($arrResponse);
    }
      
     #Validação final do login
     public function validateFinalLogin($email)
     {
         if(count($this->getErro()) >0){
             $this->login->insertAttempt();
             $arrResponse=[
                "retorno" => "erro",
                "erros"   => $this->getErro(),
                "tentativas" => $this->tentativas
            ];
         }else{
             $this->login->deleteAttempt();
             $this->session->setSessions($email);
             $arrResponse=[
                "retorno" => 'success',
                "page" => 'areaRestrita',
                "tentativas"   => $this->tentativas
            ];
         }
         return json_encode($arrResponse);
     }

}