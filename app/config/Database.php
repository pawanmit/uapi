<?php

require_once 'Application.php';

class Database {
    private static $localDbConfig = array(
            'host' => '127.0.0.1',
            'database' => 'umanly',
            'username' => 'root',
            'password' => 'mysql');


    public static function getDatabaseConfig() {
        return self::$localDbConfig;
    }

}