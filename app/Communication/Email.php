<?php

namespace App\Communication;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception as PHPMailerExcepition;

class Email{


    /**
    * Mensagem de erro
    *
    * @var string
    */
    private $error;

    /**
    * Get the value of error
    */
    public function getError()
    {
        return $this->error;
    }

    /**
    * Metódo responsavel pelo envio do email
    *
    * @param string|array $addresses destinatarios+
    * @param string $subject  assunto
    * @param string $body  descrição
    * @param string|array $attachments  anexos
    * @param string|array $ccs copias visíveis
    * @param string|array $bccs copias ocultas
    * @return boolean
    */
    public function sendEmail($addresses, $subject, $body, $attachments = [], $ccs = [], $bccs = []){

        //LIMPA A MENSAGEM DE ERRO
        $this->error = '';

        //Instacia do PHPMailer
        $objMail = new PHPMailer(true);
        try{
            //Credenciais de acsseso ao SMTP
            $objMail->isSMTP(true);
            $objMail->Host       = EMAIL_HOST;
            $objMail->SMTPAuth   = true;
            $objMail->Username   = EMAIL_USER;
            $objMail->Password   = EMAIL_PASS;
            $objMail->SMTPSecure = EMAIL_SECURE;
            $objMail->Port       = EMAIL_PORT;
            $objMail->CharSet    = EMAIL_CHARSET;

           

            //Remetente
            $objMail->setFrom(EMAIL_FORM_EMAIL,  EMAIL_FROM_NAME);

            //Destinatarios
            $addresses = is_array($addresses) ? $addresses : [$addresses];

            foreach($addresses as $address){
                $objMail->addAddress($address);
            }

            //Anexos
            $attachments = is_array($attachments) ? $attachments : [$attachments];

            foreach($attachments as $attachment){
                $objMail->addAttachment($attachment);
            }

            //ccs
            $ccs = is_array($ccs) ? $ccs : [$ccs];

            foreach($ccs as $cc){
                $objMail->addCC($cc);
            }

            //bccs
            $bccs = is_array($bccs) ? $bccs : [$bccs];

            foreach($bccs as $bcc){
                $objMail->addBCC($bcc);
            }

            //Conteudo do email
            $objMail->isHTML(true);
            $objMail->Subject = $subject;
            $objMail->Body    = $body;

            // echo '<pre>';
            // print_r($objMail->host);
            // echo '</pre>';
            // echo '<pre>';
            // print_r($objMail->SMTPAuth);
            // echo '</pre>';
            // echo '<pre>';
            // print_r($objMail->Username);
            // echo '</pre>';
            // echo '<pre>';
            // print_r($objMail->Password);
            // echo '</pre>';
            // echo '<pre>';
            // print_r($objMail->SMTPSecure);
            // echo '</pre>';
            // echo '<pre>';
            // print_r($objMail->Port);
            // echo '</pre>';
            // echo '<pre>';
            // print_r($objMail->CharSet);
            // echo '</pre>';
            // echo '<pre>';
            // print_r(EMAIL_FORM_EMAIL);
            // echo '</pre>';
            // echo '<pre>';
            // print_r(EMAIL_FROM_NAME);
            // echo '</pre>';
            // echo '<pre>';
            // print_r($addresses);
            // echo '</pre>';
            // echo '<pre>';
            // print_r($subject);
            // echo '</pre>';
            // echo '<pre>';
            // print_r($body);
            // echo '</pre>';
            // exit;

            //Envia o email
            return $objMail->send();
            
        }catch(PHPMailerExcepition $e){

            $this->error = $e->getMessage();
            return false;

        }
    }
}