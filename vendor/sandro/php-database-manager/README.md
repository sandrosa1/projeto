# PHP Gerenciador de banco de dados

Está é uma biblioteca simples para gerenciar conexões básicas de banco de dados e consultas em PHP.

## Instalação

Para executar está dependência e só executar o comando abaixo:

```Shell
composer require sandro/php-database-manager
```


## Utilização

Para usar esta biblioteca basta seguir os exemplos abaixo:

#### Banco de dados
```php
<?php

require 'vendor/autoload.php';

use SandroAmancio\DatabaseManager\Database;

//DATABASE CREDENTIALS
$dbHost = 'localhost';
$dbName = 'database';
$dbUser = 'root';
$dbPass = 'pass';
$dbPort = 3306;

//Configuração da classe de banco de dados
DataBase::config($dbHost,$dbName,$dbUser,$dbPass,$dbPort);

//Instancinado um tabela
$obDatabase = new Database('table_name');

//SELECT (return a PDOStatement object)
$results = $obDatabase->select('id > 10','name ASC','1','*');

//INSERT (return inserted id)
$id = $obDatabase->insert([
  'name' => 'Meu Nome'
]);

//UPDATE (return a bool)
$success = $obDatabase->update('id = 1',[
  'name' => 'meu nome2'
]);

//DELETE (return a bool)
$success = $obDatabase->delete('id = 1');

```


## Requerimento

- PHP >= 7.0 
