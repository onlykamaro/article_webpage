<?php

namespace App\Controllers;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;

abstract class BaseController
{
    protected Connection $database;
    public function __construct()
    {
        $connectionParams = [
            'dbname' => 'article_webpage',
            'user' => 'onlykamaro',
            'password' => 'secret',
            'host' => 'localhost',
            'driver' => 'pdo_mysql',
        ];

        $this->database = DriverManager::getConnection($connectionParams);
    }
}