<?php
namespace SandroAmancio\Search;

/**
 * Reponsavél por buscar o endereço clompleto atráves do cep
 */
class Address{

    /**
     * URL base do via cep
     *
     * @var string
     */
    private $url = "https://viacep.com.br/ws/";
   
    /**
     * Função que traz o jsoncom o cep enviado e retorna um array
     *
     * @param string $zipCode
     * @return array
     */
    public function getAddressFromZipCode(string $zipCode): array{

        
        $zipCode = preg_replace('/[^0-9]/im','', $zipCode);

        $get = file_get_contents($this->url . $zipCode ."/json");

        return (array) json_decode($get);
    }

}


