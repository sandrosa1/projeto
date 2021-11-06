# PHP Paginação

Uma biblioteca para paginação com msqly


### Requer
Biblioteca de gerenciamento de banco de dados

```Shell
composer require sandro/php-database-manager
```

## Utilização

Para usar está biblioteca basta seguir os exemplos abaixo:


```php
<?php

require 'vendor/autoload.php';

use SandroAmancio\DatabaseManager\Database;
use SandroAmancio\PaginationManager\Pagination;

//DATABASE CREDENTIALS
$dbHost = 'localhost';
$dbName = 'database';
$dbUser = 'root';
$dbPass = 'pass';
$dbPort = 3306;

//CONFIG DATABASE CLASS
Database::config($dbHost,$dbName,$dbUser,$dbPass,$dbPort);

//TABLE INSTANCE
$obDatabase = new Database('table_name');

//COUNT TOTAL RESULTS
$totalResults = $obDatabase->select('id > 10',null,null,'COUNT(*) as total')->fetchObject()->total;

//CURRENT PAGE
$currentPage  = $_GET['page'] ?? 1;
$itemsPerPage = 10;

//PAGINATION
$obPagination = new Pagination($totalResults,$currentPage,$itemsPerPage);

//SELECT (return a PDOStatement object)
$results = $obDatabase->select('id > 10',null,$obPagination->getLimit());

//PAGES (array)
$pages = $obPagination->getPages();

```

### Requerimentors

- PHP >= 7.0
- composer require sandro/php-database-manager

