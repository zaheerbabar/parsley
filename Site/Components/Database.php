<?php
namespace Site\Components;

use Doctrine\Common;
use Doctrine\DBAL;
// https://github.com/doctrine/dbal

class Database
{
    public static function loadConnection() {
        $config = new \Doctrine\DBAL\Configuration();

        $conParams = [
            'dbname' => DB_NAME,
            'user' => DB_USER,
            'password' => DB_PASSWORD,
            'host' => DB_HOST,
            'charset' => 'utf8',
            'driver' => 'pdo_mysql',
        ];

        $con = \Doctrine\DBAL\DriverManager::getConnection($conParams, $config);
        $con->setFetchMode(\PDO::FETCH_ASSOC);

        return $con;
    }
}
?>