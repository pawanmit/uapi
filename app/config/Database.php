<?php

require_once 'Application.php';

class Database {
    private static $localDbConfig = array(
            'host' => '127.0.0.1',
            'database' => 'link_analyzer2',
            'username' => 'root',
            'password' => 'root');


    public static function getDatabaseConfig() {
        return self::$localDbConfig;
    }

}